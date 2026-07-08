create or replace function public.handle_new_auth_user()
returns trigger
language plpgsql
security definer
set search_path = public
as $$
declare
  v_meta jsonb;
  v_nome text;
  v_matricula text;
  v_usuario text;
  v_suffix text;
begin
  v_meta := coalesce(new.raw_user_meta_data, '{}'::jsonb);
  v_suffix := left(replace(new.id::text, '-', ''), 6);
  v_nome := nullif(trim(v_meta->>'nome_usuario'), '');
  v_matricula := nullif(trim(v_meta->>'matricula'), '');
  v_usuario := nullif(trim(v_meta->>'usuario'), '');

  insert into public.tb_usuarios (
    auth_user_id,
    nome_usuario,
    matricula,
    status,
    perfil,
    email,
    usuario
  )
  values (
    new.id,
    coalesce(v_nome, new.email, 'Usuario'),
    coalesce(v_matricula, left(replace(new.id::text, '-', ''), 14)),
    'ativo',
    0,
    new.email,
    left(coalesce(v_usuario, split_part(new.email, '@', 1), 'usuario') || '-' || v_suffix, 60)
  )
  on conflict (auth_user_id) do nothing;

  return new;
end;
$$;

drop trigger if exists on_auth_user_created on auth.users;

create trigger on_auth_user_created
after insert on auth.users
for each row execute function public.handle_new_auth_user();

insert into public.tb_usuarios (
  auth_user_id,
  nome_usuario,
  matricula,
  status,
  perfil,
  email,
  usuario
)
select
  au.id,
  coalesce(nullif(trim(au.raw_user_meta_data->>'nome_usuario'), ''), au.email, 'Usuario'),
  coalesce(nullif(trim(au.raw_user_meta_data->>'matricula'), ''), left(replace(au.id::text, '-', ''), 14)),
  'ativo',
  0,
  au.email,
  left(
    coalesce(nullif(trim(au.raw_user_meta_data->>'usuario'), ''), split_part(au.email, '@', 1), 'usuario')
    || '-'
    || left(replace(au.id::text, '-', ''), 6),
    60
  )
from auth.users au
where au.email is not null
  and not exists (
    select 1
    from public.tb_usuarios tu
    where tu.auth_user_id = au.id
       or tu.email = au.email
  );

