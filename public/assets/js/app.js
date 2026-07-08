const db = window.elixoSupabase;
const ready = window.elixoSupabaseReady;

const state = {
  profile: null,
  products: [],
  participants: []
};

const $ = (selector) => document.querySelector(selector);

function setMessage(message, isError = false) {
  const target = $("#app-message");
  target.textContent = message || "";
  target.style.color = isError ? "#b42318" : "#006f66";
}

function setStatus(message) {
  $("#connection-status").textContent = message;
}

function today() {
  return new Date().toISOString().slice(0, 10);
}

async function requireClient() {
  if (!ready || !db) {
    setStatus("Supabase nao configurado");
    setMessage("Edite public/assets/js/env.js antes de publicar.", true);
    return false;
  }

  return true;
}

async function loadProfile() {
  if (!(await requireClient())) return;

  const { data: sessionData } = await db.auth.getSession();
  const user = sessionData.session?.user;

  if (!user) {
    state.profile = null;
    setStatus("Visitante");
    fillParticipantSelect();
    return;
  }

  const { data, error } = await db
    .from("tb_usuarios")
    .select("id_usuario,nome_usuario,perfil,status,email")
    .eq("auth_user_id", user.id)
    .maybeSingle();

  if (error) {
    setMessage(error.message, true);
    return;
  }

  state.profile = data;
  setStatus(data ? `Logado: ${data.nome_usuario}` : "Conta sem perfil");
  await loadParticipants();
}

async function loadProducts() {
  if (!(await requireClient())) return;

  const { data, error } = await db
    .from("tb_dispositivos_eletronicos")
    .select("id_produto,descricao,pontuacao")
    .eq("status", "ativo")
    .order("descricao");

  if (error) {
    setMessage(error.message, true);
    return;
  }

  state.products = data || [];
  renderProducts();
  fillProductSelect();
}

function renderProducts() {
  const list = $("#product-list");
  list.innerHTML = "";

  if (!state.products.length) {
    list.innerHTML = "<p>Nenhum dispositivo ativo encontrado.</p>";
    return;
  }

  state.products.forEach((product) => {
    const item = document.createElement("article");
    item.className = "item";
    item.innerHTML = `<strong>${product.descricao}</strong><span>${product.pontuacao} pontos</span>`;
    list.appendChild(item);
  });
}

function fillProductSelect() {
  const select = $("#transaction-form select[name='id_produto']");
  select.innerHTML = "<option value=''>Selecione</option>";

  state.products.forEach((product) => {
    const option = document.createElement("option");
    option.value = product.id_produto;
    option.textContent = `${product.descricao} (${product.pontuacao} pts)`;
    select.appendChild(option);
  });
}

async function loadParticipants() {
  if (!state.profile) {
    state.participants = [];
    fillParticipantSelect();
    return;
  }

  if (Number(state.profile.perfil) === 0) {
    state.participants = [state.profile];
    fillParticipantSelect();
    return;
  }

  const { data, error } = await db
    .from("tb_usuarios")
    .select("id_usuario,nome_usuario,perfil,status")
    .eq("status", "ativo")
    .order("nome_usuario");

  if (error) {
    setMessage(error.message, true);
    return;
  }

  state.participants = data || [];
  fillParticipantSelect();
}

function fillParticipantSelect() {
  const select = $("#transaction-form select[name='id_usuario']");
  select.innerHTML = "<option value=''>Selecione</option>";

  state.participants.forEach((user) => {
    const option = document.createElement("option");
    option.value = user.id_usuario;
    option.textContent = user.nome_usuario;
    select.appendChild(option);
  });
}

async function loadRanking() {
  if (!(await requireClient())) return;

  const now = new Date();
  const { data, error } = await db
    .from("v_ranking_mensal")
    .select("id_usuario,nome_usuario,pontuacao,ano,mes")
    .eq("ano", now.getFullYear())
    .eq("mes", now.getMonth() + 1)
    .order("pontuacao", { ascending: false });

  if (error) {
    setMessage(error.message, true);
    return;
  }

  const list = $("#ranking-list");
  list.innerHTML = "";

  if (!data?.length) {
    list.innerHTML = "<p>Nenhuma pontuacao registrada neste mes.</p>";
    return;
  }

  data.forEach((row, index) => {
    const item = document.createElement("article");
    item.className = "rank-row";
    item.innerHTML = `
      <span class="rank-pos">${index + 1}</span>
      <strong>${row.nome_usuario}</strong>
      <span>${row.pontuacao} pts</span>
    `;
    list.appendChild(item);
  });
}

async function signIn(event) {
  event.preventDefault();
  if (!(await requireClient())) return;

  const form = new FormData(event.currentTarget);
  const { error } = await db.auth.signInWithPassword({
    email: form.get("email"),
    password: form.get("password")
  });

  if (error) {
    setMessage(error.message, true);
    return;
  }

  setMessage("Login realizado.");
  await loadProfile();
}

async function signUp(event) {
  event.preventDefault();
  if (!(await requireClient())) return;

  const form = new FormData(event.currentTarget);
  const email = form.get("email");
  const { data, error } = await db.auth.signUp({
    email,
    password: form.get("password"),
    options: {
      data: {
        nome_usuario: form.get("nome_usuario"),
        matricula: form.get("matricula"),
        usuario: email.split("@")[0]
      }
    }
  });

  if (error) {
    setMessage(error.message, true);
    return;
  }

  if (!data.user) {
    setMessage("Conta criada. Faca login para continuar.");
    return;
  }

  setMessage("Cadastro criado. Se a confirmacao por e-mail estiver ativa, confirme antes do login.");
  event.currentTarget.reset();
  await loadProfile();
}

async function signOut() {
  if (!(await requireClient())) return;

  await db.auth.signOut();
  state.profile = null;
  setStatus("Visitante");
  setMessage("Sessao encerrada.");
  fillParticipantSelect();
}

async function registerTransaction(event) {
  event.preventDefault();
  if (!(await requireClient())) return;

  if (!state.profile) {
    setMessage("Faca login antes de registrar uma transacao.", true);
    return;
  }

  const form = new FormData(event.currentTarget);
  const payload = {
    p_id_produto: Number(form.get("id_produto")),
    p_id_usuario: Number(form.get("id_usuario")),
    p_quantia: Number(form.get("quantia")),
    p_data: form.get("data"),
    p_desc_modelo: form.get("desc_modelo"),
    p_status: "ativo"
  };

  const { error } = await db.rpc("registrar_transacao", payload);

  if (error) {
    setMessage(error.message, true);
    return;
  }

  setMessage("Transacao registrada.");
  event.currentTarget.reset();
  $("#transaction-form input[name='data']").value = today();
  await loadRanking();
}

function bindEvents() {
  $("#refresh-ranking").addEventListener("click", loadRanking);
  $("#refresh-products").addEventListener("click", loadProducts);
  $("#login-form").addEventListener("submit", signIn);
  $("#signup-form").addEventListener("submit", signUp);
  $("#logout-button").addEventListener("click", signOut);
  $("#transaction-form").addEventListener("submit", registerTransaction);
}

async function start() {
  bindEvents();
  $("#transaction-form input[name='data']").value = today();

  if (!(await requireClient())) return;

  await loadProfile();
  await loadProducts();
  await loadRanking();

  db.auth.onAuthStateChange(async () => {
    await loadProfile();
  });
}

start();

