insert into public.tb_dispositivos_eletronicos (id_produto, descricao, pontuacao, status)
values
  (1, 'Baterias pequenas', 10, 'ativo'),
  (2, 'Pilha', 10, 'ativo'),
  (3, 'Teclado', 5, 'ativo'),
  (4, 'Mouse', 5, 'ativo'),
  (5, 'Celular', 8, 'ativo'),
  (6, 'Monitor', 4, 'ativo'),
  (7, 'Fonte', 10, 'ativo'),
  (8, 'Cabo de energia', 5, 'ativo'),
  (9, 'Cabo usb', 3, 'ativo'),
  (10, 'Chip', 3, 'ativo'),
  (11, 'Bateria de Celular', 15, 'ativo'),
  (12, 'Fonte computador', 12, 'ativo'),
  (13, 'Carregador', 5, 'ativo'),
  (14, 'Videogame', 10, 'ativo'),
  (15, 'Placa mae', 8, 'ativo'),
  (16, 'Placa de video', 7, 'ativo'),
  (17, 'Outro tipo de bateria', 12, 'ativo')
on conflict (id_produto)
do update set
  descricao = excluded.descricao,
  pontuacao = excluded.pontuacao,
  status = excluded.status;

select setval(
  pg_get_serial_sequence('public.tb_dispositivos_eletronicos', 'id_produto'),
  (select max(id_produto) from public.tb_dispositivos_eletronicos)
);

