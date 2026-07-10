create or replace view public.v_ranking_mensal
with (security_invoker = true)
as
select
  p.id_usuario_tb_fk as id_usuario,
  u.nome_usuario,
  p.ano,
  p.mes,
  p.pontuacao,
  make_date(p.ano, p.mes, 1) as mes_referencia
from public.tb_pontuacao p
join public.tb_usuarios u on u.id_usuario = p.id_usuario_tb_fk
where p.pontuacao > 0
  and u.status = 'ativo';

drop policy if exists "profiles_public_ranking" on public.tb_usuarios;
create policy "profiles_public_ranking"
on public.tb_usuarios
for select
to anon
using (status = 'ativo');

drop policy if exists "scores_public_ranking" on public.tb_pontuacao;
create policy "scores_public_ranking"
on public.tb_pontuacao
for select
to anon
using (pontuacao > 0);

grant select (id_usuario, nome_usuario, status) on public.tb_usuarios to anon;
grant select (id_pontuacao, pontuacao, ano, mes, id_usuario_tb_fk) on public.tb_pontuacao to anon;
grant select on public.v_ranking_mensal to anon, authenticated;

