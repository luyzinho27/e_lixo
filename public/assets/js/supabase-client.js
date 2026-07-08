(function () {
  const url = window.ELIXO_SUPABASE_URL;
  const anonKey = window.ELIXO_SUPABASE_ANON_KEY;
  const missingConfig =
    !url ||
    !anonKey ||
    url.includes("SEU-PROJETO") ||
    anonKey.includes("COLE_A_ANON_KEY");

  window.elixoSupabaseReady = !missingConfig;

  if (missingConfig) {
    console.warn("Configure public/assets/js/env.js com a URL e anon key do Supabase.");
    return;
  }

  window.elixoSupabase = window.supabase.createClient(url, anonKey);
})();

