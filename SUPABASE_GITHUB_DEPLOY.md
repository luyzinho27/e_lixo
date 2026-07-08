# Deploy GitHub Pages + Supabase

Esta estrutura separa o projeto legado PHP da versao online estatica:

- `public/`: frontend que o GitHub Pages publica.
- `supabase/migrations/`: schema PostgreSQL, RLS, views e RPC.
- `supabase/seed.sql`: dados publicos iniciais de dispositivos.
- `.github/workflows/deploy-pages.yml`: publicacao automatica do GitHub Pages.

Dados do ambiente criado:

- Repositorio GitHub: `e_lixo`
- Projeto Supabase: `elixo-meio-ambiente`

## 1. Criar o projeto no Supabase

1. Abra o projeto `elixo-meio-ambiente` no Supabase.
2. Abra `SQL Editor`.
3. Execute o conteudo de `supabase/migrations/20260706010000_initial_schema.sql`.
4. Execute o conteudo de `supabase/seed.sql`.
5. Execute o conteudo de `supabase/migrations/20260708090000_auth_profile_trigger.sql`.
6. Em `Authentication > Providers`, habilite `Email`.
7. Para teste local, desative confirmacao obrigatoria por e-mail. Em producao, use confirmacao por e-mail.

## 2. Configurar o frontend

1. Abra `Project Settings > API` no Supabase.
2. Copie `Project URL`.
3. Copie `anon public key`.
4. Edite `public/assets/js/env.js`:

```js
window.ELIXO_SUPABASE_URL = "https://PROJECT-REF.supabase.co";
window.ELIXO_SUPABASE_ANON_KEY = "SUA_ANON_KEY_PUBLICA";
```

Nunca coloque a `service_role key` no frontend.

Observacao: `PROJECT-REF` nao e necessariamente o nome `elixo-meio-ambiente`.
Use exatamente o valor de `Project URL` exibido no Supabase.

## 3. Publicar no GitHub Pages

1. Inicialize o Git, se ainda nao existir:

```powershell
git init
git branch -M main
git add .
git commit -m "Prepare GitHub Pages and Supabase deploy"
```

2. Use o repositorio `e_lixo` que voce ja criou no GitHub.
3. Vincule o remoto:

```powershell
git remote add origin https://github.com/SEU-USUARIO/e_lixo.git
git push -u origin main
```

4. No GitHub, abra `Settings > Pages`.
5. Em `Build and deployment`, selecione `GitHub Actions`.
6. Rode a action `Deploy GitHub Pages` ou envie novo push para `main`.

## 4. Criar usuarios administradores

O cadastro publico cria perfil `0` participante.

Para tornar um usuario servidor ou admin, altere no Supabase:

```sql
update public.tb_usuarios
set perfil = 2
where email = 'admin@exemplo.com';
```

Perfis usados:

- `0`: participante.
- `1`: servidor/operador.
- `2`: administrador.

## 5. O que ainda precisa migrar do PHP legado

Os arquivos PHP atuais continuam no projeto apenas como referencia. O GitHub
Pages nao executa PHP. Para a aplicacao completa, migre as telas antigas para
HTML/JS dentro de `public/`, usando as tabelas, views e RPC criadas no
Supabase.

## 6. Erro de RLS no cadastro

Se aparecer:

```txt
new row violates row-level security policy for table "tb_usuarios"
```

execute no Supabase SQL Editor:

```sql
-- supabase/migrations/20260708090000_auth_profile_trigger.sql
```

Esse script cria um trigger em `auth.users`. A partir dele, o cadastro cria o
usuario no Supabase Auth e o banco cria automaticamente o registro em
`public.tb_usuarios`.
