
--11/05/2010 12:14:23
UPDATE vsites_servico SET dias='', status='Ativo', descricao='Certidão Trintenária', id_departamento='', site='1' WHERE id_servico='164';
--11/05/2010 12:14:23
UPDATE vsites_servico_campo
						SET campo='certidao_cartorio',tipo='text',nome='CARTÓRIO',
							valor='',largura='470',mascara='',
							site='1',ordenacao='1',obrigatorio='1'
						WHERE id_servico_campo='1412';
--11/05/2010 12:14:23
UPDATE vsites_servico_campo
						SET campo='certidao_matricula',tipo='text',nome='MATRÍCULA',
							valor='',largura='470',mascara='',
							site='1',ordenacao='2',obrigatorio='1'
						WHERE id_servico_campo='1413';
--11/05/2010 12:14:23
UPDATE vsites_servico_campo
						SET campo='certidao_cidade',tipo='text',nome='CIDADE',
							valor='',largura='470',mascara='',
							site='1',ordenacao='3',obrigatorio='1'
						WHERE id_servico_campo='1414';
--11/05/2010 12:14:23
UPDATE vsites_servico_campo
						SET campo='certidao_estado',tipo='text',nome='UF',
							valor='',largura='470',mascara='',
							site='1',ordenacao='4',obrigatorio='1'
						WHERE id_servico_campo='1415';
--11/05/2010 12:14:23
DELETE FROM vsites_servico_campo WHERE id_servico_campo = '' AND id_servico='164';
--11/05/2010 12:14:41
INSERT INTO vsites_servico (id_departamento, status, site, descricao) VALUES ('13','Ativo','1','teste')
--11/05/2010 12:14:41
INSERT INTO vsites_servico_campo (id_servico, campo, nome, tipo, largura, site, ordenacao) VALUES ('0','certidao_averbacao','TESTE','text','470','0','1')
--11/05/2010 12:20:49
INSERT INTO vsites_servico (id_departamento, status, site, descricao) VALUES ('13','Ativo','','teste');
--11/05/2010 12:20:49
INSERT INTO vsites_servico_campo (id_servico, campo, nome, tipo, largura, site, ordenacao) VALUES ('0','certidao_averbacao','TESTE','text','470','0','1');
--11/05/2010 12:21:18
UPDATE vsites_servico SET dias='', status='Ativo', descricao='Certidão de Transcrição', id_departamento='', site='1' WHERE id_servico='167';
--11/05/2010 12:21:18
UPDATE vsites_servico_campo
						SET campo='certidao_cartorio',tipo='text',nome='CARTÓRIO',
							valor='',largura='470',mascara='',
							site='1',ordenacao='1',obrigatorio='1'
						WHERE id_servico_campo='1424';
--11/05/2010 12:21:18
UPDATE vsites_servico_campo
						SET campo='certidao_transcricao',tipo='text',nome='TRANSCRIÇÃO',
							valor='',largura='470',mascara='',
							site='1',ordenacao='2',obrigatorio='1'
						WHERE id_servico_campo='1425';
--11/05/2010 12:21:18
UPDATE vsites_servico_campo
						SET campo='certidao_cidade',tipo='text',nome='CIDADE',
							valor='',largura='470',mascara='',
							site='1',ordenacao='3',obrigatorio='1'
						WHERE id_servico_campo='1426';
--11/05/2010 12:21:18
UPDATE vsites_servico_campo
						SET campo='certidao_estado',tipo='text',nome='UF',
							valor='',largura='470',mascara='',
							site='1',ordenacao='4',obrigatorio='1'
						WHERE id_servico_campo='1427';
--11/05/2010 12:21:18
DELETE FROM vsites_servico_campo WHERE id_servico_campo = '' AND id_servico='167';
--11/05/2010 12:23:37
UPDATE vsites_servico SET dias='', status='Ativo', descricao='Falência e Concordata',  site='1' WHERE id_servico='25';
--11/05/2010 12:23:37
UPDATE vsites_servico_campo
						SET campo='certidao_nome',tipo='text',nome='NOME',
							valor='',largura='470',mascara='',
							site='1',ordenacao='1',obrigatorio='1'
						WHERE id_servico_campo='769';
--11/05/2010 12:23:38
UPDATE vsites_servico_campo
						SET campo='certidao_rg',tipo='text',nome='RG',
							valor='',largura='470',mascara='',
							site='1',ordenacao='2',obrigatorio='0'
						WHERE id_servico_campo='1168';
--11/05/2010 12:23:38
UPDATE vsites_servico_campo
						SET campo='certidao_cpf',tipo='text',nome='CPF',
							valor='',largura='470',mascara='',
							site='1',ordenacao='3',obrigatorio='0'
						WHERE id_servico_campo='316';
--11/05/2010 12:23:38
UPDATE vsites_servico_campo
						SET campo='certidao_cnpj',tipo='text',nome='CNPJ',
							valor='',largura='470',mascara='',
							site='1',ordenacao='4',obrigatorio='0'
						WHERE id_servico_campo='233';
--11/05/2010 12:23:38
UPDATE vsites_servico_campo
						SET campo='certidao_cidade',tipo='text',nome='CIDADE',
							valor='',largura='470',mascara='',
							site='1',ordenacao='5',obrigatorio='1'
						WHERE id_servico_campo='146';
--11/05/2010 12:23:38
UPDATE vsites_servico_campo
						SET campo='certidao_estado',tipo='text',nome='ESTADO',
							valor='',largura='470',mascara='',
							site='1',ordenacao='6',obrigatorio='1'
						WHERE id_servico_campo='510';
--11/05/2010 12:23:38
UPDATE vsites_servico_campo
						SET campo='certidao_finalidade',tipo='text',nome='FINALIDADE',
							valor='',largura='470',mascara='',
							site='0',ordenacao='7',obrigatorio='0'
						WHERE id_servico_campo='1557';
--11/05/2010 12:23:38
UPDATE vsites_servico_campo
						SET campo='certidao_protocolo',tipo='text',nome='PROTOCOLO',
							valor='',largura='470',mascara='',
							site='0',ordenacao='8',obrigatorio='1'
						WHERE id_servico_campo='989';
--11/05/2010 12:23:38
DELETE FROM vsites_servico_campo WHERE id_servico_campo = '' AND id_servico='25';
--11/05/2010 12:29:23
UPDATE vsites_servico SET dias='', status='Ativo', descricao='Tributos Imobiliários', site='1' WHERE id_servico='136';
--11/05/2010 12:29:23
UPDATE vsites_servico_campo SET campo='certidao_nome',tipo='text',nome='NOME',valor='',largura='470',mascara='',site='1',ordenacao='1',obrigatorio='1'
						WHERE id_servico_campo='816';
--11/05/2010 12:29:23
UPDATE vsites_servico_campo SET campo='certidao_cidade',tipo='text',nome='CIDADE',valor='',largura='470',mascara='',site='1',ordenacao='2',obrigatorio='1'
						WHERE id_servico_campo='197';
--11/05/2010 12:29:23
UPDATE vsites_servico_campo SET campo='certidao_estado',tipo='text',nome='ESTADO',valor='',largura='470',mascara='',site='1',ordenacao='3',obrigatorio='1'
						WHERE id_servico_campo='561';
--11/05/2010 12:29:23
UPDATE vsites_servico_campo SET campo='certidao_cnpj',tipo='text',nome='CNPJ',valor='',largura='470',mascara='',site='1',ordenacao='4',obrigatorio='0'
						WHERE id_servico_campo='264';
--11/05/2010 12:29:23
UPDATE vsites_servico_campo SET campo='certidao_n_contribuinte',tipo='text',nome='N DO CONTRIBUINTE (IPTU)',valor='',largura='470',mascara='',site='1',ordenacao='5',obrigatorio='1'
						WHERE id_servico_campo='713';
--11/05/2010 12:29:23
DELETE FROM vsites_servico_campo WHERE id_servico_campo = '' AND id_servico='136';
--11/05/2010 12:34:18
INSERT INTO vsites_servico (id_departamento, status, site, descricao) VALUES ('13','Ativo','','');
--11/05/2010 12:34:24
INSERT INTO vsites_servico (id_departamento, status, site, descricao) VALUES ('13','Ativo','','');
--11/05/2010 12:34:24
INSERT INTO vsites_servico_campo (id_servico, campo, nome, tipo, largura, site, ordenacao) VALUES ('0','certidao_averbacao','','text','470','0','1');





--12/05/2010 11:14:36
UPDATE vsites_servico SET dias='', status='Ativo', descricao='Batismo',  site='1' WHERE id_servico='83';
--12/05/2010 11:14:36
UPDATE vsites_servico_campo SET campo='certidao_nome',tipo='text',nome='NOME',valor='',largura='470',mascara='',site='1',ordenacao='1',obrigatorio='1'
						WHERE id_servico_campo='735';
--12/05/2010 11:14:36
UPDATE vsites_servico_campo SET campo='certidao_mae',tipo='text',nome='MAE',valor='',largura='470',mascara='',site='1',ordenacao='2',obrigatorio='1'
						WHERE id_servico_campo='641';
--12/05/2010 11:14:36
UPDATE vsites_servico_campo SET campo='certidao_pai',tipo='text',nome='PAI',valor='',largura='470',mascara='',site='1',ordenacao='3',obrigatorio='0'
						WHERE id_servico_campo='907';
--12/05/2010 11:14:36
UPDATE vsites_servico_campo SET campo='certidao_data_batismo',tipo='text',nome='DATA DO BATISMO',valor='',largura='470',mascara='',site='1',ordenacao='4',obrigatorio='1'
						WHERE id_servico_campo='416';
--12/05/2010 11:14:36
UPDATE vsites_servico_campo SET campo='certidao_igreja',tipo='text',nome='IGREJA',valor='',largura='470',mascara='',site='1',ordenacao='5',obrigatorio='1'
						WHERE id_servico_campo='1544';
--12/05/2010 11:14:36
UPDATE vsites_servico_campo SET campo='certidao_cidade',tipo='text',nome='CIDADE',valor='',largura='470',mascara='',site='1',ordenacao='6',obrigatorio='1'
						WHERE id_servico_campo='113';
--12/05/2010 11:14:36
UPDATE vsites_servico_campo SET campo='certidao_estado',tipo='text',nome='ESTADO',valor='',largura='470',mascara='',site='1',ordenacao='7',obrigatorio='1'
						WHERE id_servico_campo='479';
--12/05/2010 11:14:36
UPDATE vsites_servico_campo SET campo='certidao_padre',tipo='text',nome='PADRE',valor='',largura='470',mascara='',site='1',ordenacao='8',obrigatorio='0'
						WHERE id_servico_campo='903';
--12/05/2010 11:14:36
DELETE FROM vsites_servico_campo WHERE id_servico_campo = '' AND id_servico='83';
--12/05/2010 11:17:06
UPDATE vsites_servico SET dias='', status='Ativo', descricao='Nascimento', `vsites_servico_var` site='1' WHERE id_servico='2';
--12/05/2010 11:17:06
UPDATE vsites_servico_campo SET campo='certidao_nome',tipo='text',nome='NOME',valor='',largura='470',mascara='',site='1',ordenacao='1',obrigatorio='1'
						WHERE id_servico_campo='785';
--12/05/2010 11:17:06
UPDATE vsites_servico_campo SET campo='certidao_mae',tipo='text',nome='MAE',valor='',largura='470',mascara='',site='1',ordenacao='2',obrigatorio='1'
						WHERE id_servico_campo='655';
--12/05/2010 11:17:06
UPDATE vsites_servico_campo SET campo='certidao_pai',tipo='text',nome='PAI',valor='',largura='470',mascara='',site='1',ordenacao='3',obrigatorio='0'
						WHERE id_servico_campo='921';
--12/05/2010 11:17:06
UPDATE vsites_servico_campo SET campo='certidao_data_nascimento',tipo='text',nome='DATA DE NASCIMENTO',valor='',largura='470',mascara='',site='1',ordenacao='4',obrigatorio='1'
						WHERE id_servico_campo='404';
--12/05/2010 11:17:06
UPDATE vsites_servico_campo SET campo='certidao_livro',tipo='text',nome='LIVRO',valor='',largura='470',mascara='',site='1',ordenacao='5',obrigatorio='0'
						WHERE id_servico_campo='627';
--12/05/2010 11:17:06
UPDATE vsites_servico_campo SET campo='certidao_folha',tipo='text',nome='FOLHA',valor='',largura='470',mascara='',site='1',ordenacao='6',obrigatorio='0'
						WHERE id_servico_campo='605';
--12/05/2010 11:17:06
UPDATE vsites_servico_campo SET campo='certidao_registro',tipo='text',nome='REGISTRO',valor='',largura='470',mascara='',site='1',ordenacao='7',obrigatorio='0'
						WHERE id_servico_campo='1050';
--12/05/2010 11:17:06
UPDATE vsites_servico_campo SET campo='certidao_cidade',tipo='text',nome='CIDADE',valor='',largura='470',mascara='',site='1',ordenacao='8',obrigatorio='1'
						WHERE id_servico_campo='163';
--12/05/2010 11:17:06
UPDATE vsites_servico_campo SET campo='certidao_estado',tipo='text',nome='ESTADO',valor='',largura='470',mascara='',site='1',ordenacao='9',obrigatorio='1'
						WHERE id_servico_campo='527';
--12/05/2010 11:17:06
UPDATE vsites_servico_campo SET campo='certidao_cartorio',tipo='text',nome='CARTORIO',valor='',largura='470',mascara='',site='1',ordenacao='10',obrigatorio='0'
						WHERE id_servico_campo='54';
--12/05/2010 11:17:06
UPDATE vsites_servico_campo SET campo='certidao_data_registro',tipo='text',nome='DATA DO REGISTRO',valor='',largura='470',mascara='',site='1',ordenacao='11',obrigatorio='0'
						WHERE id_servico_campo='423';
--12/05/2010 11:17:06
UPDATE vsites_servico_campo SET campo='certidao_averbacao',tipo='text',nome='AVERBACAO',valor='',largura='470',mascara='',site='1',ordenacao='12',obrigatorio='0'
						WHERE id_servico_campo='11';
--12/05/2010 11:17:06
UPDATE vsites_servico_campo SET campo='certidao_finalidade',tipo='text',nome='FINALIDADE DO DOCUMENTO',valor='',largura='470',mascara='',site='1',ordenacao='13',obrigatorio='0'
						WHERE id_servico_campo='584';
--12/05/2010 11:17:06
UPDATE vsites_servico_campo SET campo='certidao_cartorio_cep',tipo='text',nome='CEP DO CARTORIO',valor='',largura='470',mascara='',site='1',ordenacao='14',obrigatorio='0'
						WHERE id_servico_campo='98';
--12/05/2010 11:17:06
UPDATE vsites_servico_campo SET campo='certidao_protocolo',tipo='text',nome='PROTOCOLO',valor='',largura='470',mascara='',site='0',ordenacao='15',obrigatorio='0'
						WHERE id_servico_campo='1001';
--12/05/2010 11:17:06
UPDATE vsites_servico_campo SET campo='certidao_tem_copia_doc',tipo='text',nome='TEM COPIA DO DOCUMENTO',valor='',largura='470',mascara='',site='1',ordenacao='16',obrigatorio='0'
						WHERE id_servico_campo='1228';
--12/05/2010 11:17:06
DELETE FROM vsites_servico_campo WHERE id_servico_campo = '' AND id_servico='2';
--12/05/2010 11:18:43
UPDATE vsites_servico SET dias='', status='Ativo', descricao='Óbito', `vsites_servico_var` site='1' WHERE id_servico='4';
--12/05/2010 11:18:43
UPDATE vsites_servico_campo SET campo='certidao_nome',tipo='text',nome='NOME',valor='',largura='470',mascara='',site='1',ordenacao='1',obrigatorio='1'
						WHERE id_servico_campo='791';
--12/05/2010 11:18:43
UPDATE vsites_servico_campo SET campo='certidao_mae',tipo='text',nome='MAE',valor='',largura='470',mascara='',site='1',ordenacao='2',obrigatorio='0'
						WHERE id_servico_campo='657';
--12/05/2010 11:18:43
UPDATE vsites_servico_campo SET campo='certidao_pai',tipo='text',nome='PAI',valor='',largura='470',mascara='',site='1',ordenacao='3',obrigatorio='0'
						WHERE id_servico_campo='923';
--12/05/2010 11:18:43
UPDATE vsites_servico_campo SET campo='certidao_data_obito',tipo='text',nome='DATA DE OBITO',valor='',largura='470',mascara='',site='1',ordenacao='4',obrigatorio='1'
						WHERE id_servico_campo='413';
--12/05/2010 11:18:43
UPDATE vsites_servico_campo SET campo='certidao_livro',tipo='text',nome='LIVRO',valor='',largura='470',mascara='',site='1',ordenacao='5',obrigatorio='0'
						WHERE id_servico_campo='629';
--12/05/2010 11:18:43
UPDATE vsites_servico_campo SET campo='certidao_folha',tipo='text',nome='FOLHA',valor='',largura='470',mascara='',site='1',ordenacao='6',obrigatorio='0'
						WHERE id_servico_campo='607';
--12/05/2010 11:18:43
UPDATE vsites_servico_campo SET campo='certidao_termo',tipo='text',nome='TERMO',valor='',largura='470',mascara='',site='1',ordenacao='7',obrigatorio='0'
						WHERE id_servico_campo='1230';
--12/05/2010 11:18:43
UPDATE vsites_servico_campo SET campo='certidao_cidade',tipo='text',nome='CIDADE',valor='',largura='470',mascara='',site='1',ordenacao='8',obrigatorio='1'
						WHERE id_servico_campo='169';
--12/05/2010 11:18:43
UPDATE vsites_servico_campo SET campo='certidao_estado',tipo='text',nome='ESTADO',valor='',largura='470',mascara='',site='1',ordenacao='9',obrigatorio='1'
						WHERE id_servico_campo='533';
--12/05/2010 11:18:43
UPDATE vsites_servico_campo SET campo='certidao_cartorio',tipo='text',nome='CARTORIO',valor='',largura='470',mascara='',site='1',ordenacao='10',obrigatorio='0'
						WHERE id_servico_campo='59';
--12/05/2010 11:18:43
UPDATE vsites_servico_campo SET campo='certidao_cartorio_endereco',tipo='text',nome='ENDERECO DO CARTORIO',valor='',largura='470',mascara='',site='1',ordenacao='11',obrigatorio='0'
						WHERE id_servico_campo='460';
--12/05/2010 11:18:43
UPDATE vsites_servico_campo SET campo='certidao_averbacao',tipo='text',nome='AVERBACAO',valor='',largura='470',mascara='',site='1',ordenacao='12',obrigatorio='0'
						WHERE id_servico_campo='13';
--12/05/2010 11:18:43
UPDATE vsites_servico_campo SET campo='certidao_finalidade',tipo='text',nome='FINALIDADE DO DOCUMENTO',valor='',largura='470',mascara='',site='1',ordenacao='13',obrigatorio='0'
						WHERE id_servico_campo='586';
--12/05/2010 11:18:43
UPDATE vsites_servico_campo SET campo='certidao_registro',tipo='text',nome='REGISTRO',valor='',largura='470',mascara='',site='1',ordenacao='14',obrigatorio='0'
						WHERE id_servico_campo='1052';
--12/05/2010 11:18:43
UPDATE vsites_servico_campo SET campo='certidao_data_registro',tipo='text',nome='DATA DO REGISTRO',valor='',largura='470',mascara='',site='1',ordenacao='15',obrigatorio='0'
						WHERE id_servico_campo='425';
--12/05/2010 11:18:43
UPDATE vsites_servico_campo SET campo='certidao_protocolo',tipo='text',nome='PROTOCOLO',valor='',largura='470',mascara='',site='0',ordenacao='16',obrigatorio='0'
						WHERE id_servico_campo='1007';
--12/05/2010 11:18:43
DELETE FROM vsites_servico_campo WHERE id_servico_campo = '' AND id_servico='4';
--12/05/2010 11:19:40
UPDATE vsites_servico SET dias='', status='Ativo', descricao='Casamento', `vsites_servico_var` site='1' WHERE id_servico='3';
--12/05/2010 11:19:40
UPDATE vsites_servico_campo SET campo='certidao_nome',tipo='text',nome='NOME',valor='',largura='470',mascara='',site='1',ordenacao='1',obrigatorio='1'
						WHERE id_servico_campo='745';
--12/05/2010 11:19:40
UPDATE vsites_servico_campo SET campo='certidao_esposa',tipo='text',nome='ESPOSA/ESPOSO',valor='',largura='470',mascara='',site='1',ordenacao='2',obrigatorio='1'
						WHERE id_servico_campo='464';
--12/05/2010 11:19:40
UPDATE vsites_servico_campo SET campo='certidao_data_casamento',tipo='text',nome='DATA DE CASAMENTO',valor='',largura='470',mascara='',site='1',ordenacao='3',obrigatorio='1'
						WHERE id_servico_campo='364';
--12/05/2010 11:19:40
UPDATE vsites_servico_campo SET campo='certidao_livro',tipo='text',nome='LIVRO',valor='',largura='470',mascara='',site='1',ordenacao='4',obrigatorio='0'
						WHERE id_servico_campo='619';
--12/05/2010 11:19:40
UPDATE vsites_servico_campo SET campo='certidao_folha',tipo='text',nome='FOLHA',valor='',largura='470',mascara='',site='1',ordenacao='5',obrigatorio='0'
						WHERE id_servico_campo='596';
--12/05/2010 11:19:40
UPDATE vsites_servico_campo SET campo='certidao_registro',tipo='text',nome='REGISTRO',valor='',largura='470',mascara='',site='1',ordenacao='6',obrigatorio='0'
						WHERE id_servico_campo='1044';
--12/05/2010 11:19:40
UPDATE vsites_servico_campo SET campo='certidao_cidade',tipo='text',nome='CIDADE',valor='',largura='470',mascara='',site='1',ordenacao='7',obrigatorio='1'
						WHERE id_servico_campo='122';
--12/05/2010 11:19:40
UPDATE vsites_servico_campo SET campo='certidao_estado',tipo='text',nome='ESTADO',valor='',largura='470',mascara='',site='1',ordenacao='8',obrigatorio='1'
						WHERE id_servico_campo='488';
--12/05/2010 11:19:40
UPDATE vsites_servico_campo SET campo='certidao_averbacao',tipo='text',nome='AVERBACAO',valor='',largura='470',mascara='',site='1',ordenacao='9',obrigatorio='0'
						WHERE id_servico_campo='5';
--12/05/2010 11:19:40
UPDATE vsites_servico_campo SET campo='certidao_cartorio',tipo='text',nome='CARTORIO',valor='',largura='470',mascara='',site='1',ordenacao='10',obrigatorio='0'
						WHERE id_servico_campo='34';
--12/05/2010 11:19:40
UPDATE vsites_servico_campo SET campo='certidao_finalidade',tipo='text',nome='FINALIDADE DO DOCUMENTO',valor='',largura='470',mascara='',site='1',ordenacao='11',obrigatorio='0'
						WHERE id_servico_campo='578';
--12/05/2010 11:19:40
DELETE FROM vsites_servico_campo WHERE id_servico_campo = '' AND id_servico='3';
--12/05/2010 11:19:59
UPDATE vsites_servico SET dias='', status='Ativo', descricao='Casamento', `vsites_servico_var` site='1' WHERE id_servico='3';
--12/05/2010 11:19:59
UPDATE vsites_servico_campo SET campo='certidao_nome',tipo='text',nome='NOME',valor='',largura='470',mascara='',site='1',ordenacao='1',obrigatorio='1'
						WHERE id_servico_campo='745';
--12/05/2010 11:19:59
UPDATE vsites_servico_campo SET campo='certidao_esposa',tipo='text',nome='ESPOSA/ESPOSO',valor='',largura='470',mascara='',site='1',ordenacao='2',obrigatorio='1'
						WHERE id_servico_campo='464';
--12/05/2010 11:19:59
UPDATE vsites_servico_campo SET campo='certidao_data_casamento',tipo='text',nome='DATA DE CASAMENTO',valor='',largura='470',mascara='',site='1',ordenacao='3',obrigatorio='1'
						WHERE id_servico_campo='364';
--12/05/2010 11:19:59
UPDATE vsites_servico_campo SET campo='certidao_livro',tipo='text',nome='LIVRO',valor='',largura='470',mascara='',site='1',ordenacao='4',obrigatorio='0'
						WHERE id_servico_campo='619';
--12/05/2010 11:19:59
UPDATE vsites_servico_campo SET campo='certidao_folha',tipo='text',nome='FOLHA',valor='',largura='470',mascara='',site='1',ordenacao='5',obrigatorio='0'
						WHERE id_servico_campo='596';
--12/05/2010 11:19:59
UPDATE vsites_servico_campo SET campo='certidao_registro',tipo='text',nome='REGISTRO',valor='',largura='470',mascara='',site='1',ordenacao='6',obrigatorio='0'
						WHERE id_servico_campo='1044';
--12/05/2010 11:19:59
UPDATE vsites_servico_campo SET campo='certidao_cidade',tipo='text',nome='CIDADE',valor='',largura='470',mascara='',site='1',ordenacao='7',obrigatorio='1'
						WHERE id_servico_campo='122';
--12/05/2010 11:19:59
UPDATE vsites_servico_campo SET campo='certidao_estado',tipo='text',nome='ESTADO',valor='',largura='470',mascara='',site='1',ordenacao='8',obrigatorio='1'
						WHERE id_servico_campo='488';
--12/05/2010 11:19:59
UPDATE vsites_servico_campo SET campo='certidao_averbacao',tipo='text',nome='AVERBACAO',valor='',largura='470',mascara='',site='1',ordenacao='9',obrigatorio='0'
						WHERE id_servico_campo='5';
--12/05/2010 11:19:59
UPDATE vsites_servico_campo SET campo='certidao_cartorio',tipo='text',nome='CARTORIO',valor='',largura='470',mascara='',site='1',ordenacao='10',obrigatorio='0'
						WHERE id_servico_campo='34';
--12/05/2010 11:19:59
UPDATE vsites_servico_campo SET campo='certidao_finalidade',tipo='text',nome='FINALIDADE DO DOCUMENTO',valor='',largura='470',mascara='',site='1',ordenacao='11',obrigatorio='0'
						WHERE id_servico_campo='578';
--12/05/2010 11:19:59
DELETE FROM vsites_servico_campo WHERE id_servico_campo = '' AND id_servico='3';
--12/05/2010 11:20:50
UPDATE vsites_servico SET dias='', status='Ativo', descricao='Inteiro Teor - Casamento', `vsites_servico_var` site='1' WHERE id_servico='10';
--12/05/2010 11:20:50
UPDATE vsites_servico_campo SET campo='certidao_nome',tipo='text',nome='NOME',valor='',largura='470',mascara='',site='1',ordenacao='1',obrigatorio='1'
						WHERE id_servico_campo='772';
--12/05/2010 11:20:50
UPDATE vsites_servico_campo SET campo='certidao_esposa',tipo='text',nome='ESPOSA/ESPOSO',valor='',largura='470',mascara='',site='1',ordenacao='2',obrigatorio='1'
						WHERE id_servico_campo='465';
--12/05/2010 11:20:50
UPDATE vsites_servico_campo SET campo='certidao_data_casamento',tipo='text',nome='DATA DE CASAMENTO',valor='',largura='470',mascara='',site='1',ordenacao='3',obrigatorio='1'
						WHERE id_servico_campo='365';
--12/05/2010 11:20:50
UPDATE vsites_servico_campo SET campo='certidao_livro',tipo='text',nome='LIVRO',valor='',largura='470',mascara='',site='1',ordenacao='4',obrigatorio='0'
						WHERE id_servico_campo='624';
--12/05/2010 11:20:50
UPDATE vsites_servico_campo SET campo='certidao_folha',tipo='text',nome='FOLHA',valor='',largura='470',mascara='',site='1',ordenacao='5',obrigatorio='0'
						WHERE id_servico_campo='602';
--12/05/2010 11:20:50
UPDATE vsites_servico_campo SET campo='certidao_registro',tipo='text',nome='REGISTRO',valor='',largura='470',mascara='',site='1',ordenacao='6',obrigatorio='0'
						WHERE id_servico_campo='1047';
--12/05/2010 11:20:50
UPDATE vsites_servico_campo SET campo='certidao_cidade',tipo='text',nome='CIDADE',valor='',largura='470',mascara='',site='1',ordenacao='7',obrigatorio='1'
						WHERE id_servico_campo='148';
--12/05/2010 11:20:50
UPDATE vsites_servico_campo SET campo='certidao_averbacao',tipo='text',nome='AVERBACAO',valor='',largura='470',mascara='',site='1',ordenacao='8',obrigatorio='0'
						WHERE id_servico_campo='8';
--12/05/2010 11:20:50
UPDATE vsites_servico_campo SET campo='certidao_estado',tipo='text',nome='ESTADO',valor='',largura='470',mascara='',site='1',ordenacao='9',obrigatorio='1'
						WHERE id_servico_campo='512';
--12/05/2010 11:20:50
UPDATE vsites_servico_campo SET campo='certidao_cartorio',tipo='text',nome='CARTORIO',valor='',largura='470',mascara='',site='1',ordenacao='10',obrigatorio='0'
						WHERE id_servico_campo='47';
--12/05/2010 11:20:50
UPDATE vsites_servico_campo SET campo='certidao_finalidade',tipo='text',nome='FINALIDADE DO DOCUMENTO',valor='',largura='470',mascara='',site='1',ordenacao='11',obrigatorio='0'
						WHERE id_servico_campo='581';
--12/05/2010 11:20:50
DELETE FROM vsites_servico_campo WHERE id_servico_campo = '' AND id_servico='10';
--12/05/2010 11:22:15
UPDATE vsites_servico SET dias='', status='Ativo', descricao='Inteiro Teor - Nascimento', `vsites_servico_var` site='1' WHERE id_servico='178';
--12/05/2010 11:22:15
UPDATE vsites_servico_campo SET campo='certidao_nome',tipo='text',nome='NOME',valor='',largura='470',mascara='',site='1',ordenacao='1',obrigatorio='1'
						WHERE id_servico_campo='1527';
--12/05/2010 11:22:15
UPDATE vsites_servico_campo SET campo='certidao_mae',tipo='text',nome='MÃE',valor='',largura='470',mascara='',site='1',ordenacao='2',obrigatorio='1'
						WHERE id_servico_campo='1531';
--12/05/2010 11:22:15
UPDATE vsites_servico_campo SET campo='certidao_pai',tipo='text',nome='PAI',valor='',largura='470',mascara='',site='1',ordenacao='3',obrigatorio='0'
						WHERE id_servico_campo='1532';
--12/05/2010 11:22:15
UPDATE vsites_servico_campo SET campo='certidao_data_nascimento',tipo='text',nome='DATA DE NASCIMENTO',valor='',largura='470',mascara='',site='1',ordenacao='4',obrigatorio='1'
						WHERE id_servico_campo='1528';
--12/05/2010 11:22:15
UPDATE vsites_servico_campo SET campo='certidao_livro',tipo='text',nome='LIVRO',valor='',largura='470',mascara='',site='1',ordenacao='5',obrigatorio='0'
						WHERE id_servico_campo='1533';
--12/05/2010 11:22:15
UPDATE vsites_servico_campo SET campo='certidao_folha',tipo='text',nome='FOLHA',valor='',largura='470',mascara='',site='1',ordenacao='6',obrigatorio='0'
						WHERE id_servico_campo='1534';
--12/05/2010 11:22:15
UPDATE vsites_servico_campo SET campo='certidao_registro',tipo='text',nome='REGISTRO',valor='',largura='470',mascara='',site='1',ordenacao='7',obrigatorio='0'
						WHERE id_servico_campo='1538';
--12/05/2010 11:22:15
UPDATE vsites_servico_campo SET campo='certidao_cidade',tipo='text',nome='CIDADE',valor='',largura='470',mascara='',site='1',ordenacao='8',obrigatorio='1'
						WHERE id_servico_campo='1529';
--12/05/2010 11:22:15
UPDATE vsites_servico_campo SET campo='certidao_estado',tipo='text',nome='ESTADO',valor='',largura='470',mascara='',site='1',ordenacao='9',obrigatorio='1'
						WHERE id_servico_campo='1530';
--12/05/2010 11:22:15
UPDATE vsites_servico_campo SET campo='certidao_cartorio',tipo='text',nome='CARTÓRIO',valor='',largura='470',mascara='',site='1',ordenacao='10',obrigatorio='0'
						WHERE id_servico_campo='1536';
--12/05/2010 11:22:15
UPDATE vsites_servico_campo SET campo='certidao_cartorio_cep',tipo='text',nome='CEP DO CARTÓRIO',valor='',largura='470',mascara='',site='1',ordenacao='11',obrigatorio='0'
						WHERE id_servico_campo='1537';
--12/05/2010 11:22:15
UPDATE vsites_servico_campo SET campo='certidao_data_registro',tipo='text',nome='DATA DO REGISTRO',valor='',largura='470',mascara='',site='1',ordenacao='12',obrigatorio='0'
						WHERE id_servico_campo='1539';
--12/05/2010 11:22:15
UPDATE vsites_servico_campo SET campo='certidao_averbacao',tipo='text',nome='AVERBAÇÃO',valor='',largura='470',mascara='',site='1',ordenacao='13',obrigatorio='0'
						WHERE id_servico_campo='1540';
--12/05/2010 11:22:15
UPDATE vsites_servico_campo SET campo='certidao_finalidade',tipo='text',nome='FINALIDADE',valor='',largura='470',mascara='',site='1',ordenacao='14',obrigatorio='0'
						WHERE id_servico_campo='1541';
--12/05/2010 11:22:15
UPDATE vsites_servico_campo SET campo='certidao_tem_copia_doc',tipo='text',nome='TEM CÓPIA DO DOC',valor='',largura='470',mascara='',site='1',ordenacao='15',obrigatorio='0'
						WHERE id_servico_campo='1542';
--12/05/2010 11:22:15
UPDATE vsites_servico_campo SET campo='certidao_protocolo',tipo='text',nome='PROTOCOLO',valor='',largura='470',mascara='',site='0',ordenacao='16',obrigatorio='0'
						WHERE id_servico_campo='1535';
--12/05/2010 11:22:15
DELETE FROM vsites_servico_campo WHERE id_servico_campo = '' AND id_servico='178';
--12/05/2010 11:23:16
UPDATE vsites_servico SET dias='', status='Ativo', descricao='Inteiro Teor - Óbito', `vsites_servico_var` site='1' WHERE id_servico='177';
--12/05/2010 11:23:16
UPDATE vsites_servico_campo SET campo='certidao_nome',tipo='text',nome='NOME',valor='',largura='470',mascara='',site='1',ordenacao='1',obrigatorio='1'
						WHERE id_servico_campo='1512';
--12/05/2010 11:23:16
UPDATE vsites_servico_campo SET campo='certidao_mae',tipo='text',nome='MÃE',valor='',largura='470',mascara='',site='1',ordenacao='2',obrigatorio='0'
						WHERE id_servico_campo='1515';
--12/05/2010 11:23:16
UPDATE vsites_servico_campo SET campo='certidao_pai',tipo='text',nome='PAI',valor='',largura='470',mascara='',site='1',ordenacao='3',obrigatorio='0'
						WHERE id_servico_campo='1516';
--12/05/2010 11:23:16
UPDATE vsites_servico_campo SET campo='certidao_data_obito',tipo='text',nome='DATA DE ÓBITO',valor='',largura='470',mascara='',site='1',ordenacao='4',obrigatorio='1'
						WHERE id_servico_campo='1517';
--12/05/2010 11:23:16
UPDATE vsites_servico_campo SET campo='certidao_livro',tipo='text',nome='LIVRO',valor='',largura='470',mascara='',site='1',ordenacao='5',obrigatorio='0'
						WHERE id_servico_campo='1518';
--12/05/2010 11:23:16
UPDATE vsites_servico_campo SET campo='certidao_folha',tipo='text',nome='FOLHA',valor='',largura='470',mascara='',site='1',ordenacao='6',obrigatorio='0'
						WHERE id_servico_campo='1519';
--12/05/2010 11:23:16
UPDATE vsites_servico_campo SET campo='certidao_termo',tipo='text',nome='TERMO',valor='',largura='470',mascara='',site='1',ordenacao='7',obrigatorio='0'
						WHERE id_servico_campo='1520';
--12/05/2010 11:23:16
UPDATE vsites_servico_campo SET campo='certidao_cidade',tipo='text',nome='CIDADE',valor='',largura='470',mascara='',site='1',ordenacao='8',obrigatorio='1'
						WHERE id_servico_campo='1513';
--12/05/2010 11:23:16
UPDATE vsites_servico_campo SET campo='certidao_estado',tipo='text',nome='ESTADO',valor='',largura='470',mascara='',site='1',ordenacao='9',obrigatorio='1'
						WHERE id_servico_campo='1514';
--12/05/2010 11:23:16
UPDATE vsites_servico_campo SET campo='certidao_cartorio',tipo='text',nome='CARTÓRIO',valor='',largura='470',mascara='',site='1',ordenacao='10',obrigatorio='0'
						WHERE id_servico_campo='1521';
--12/05/2010 11:23:16
UPDATE vsites_servico_campo SET campo='certidao_cartorio_endereco',tipo='text',nome='ENDEREÇO CARTÓRIO',valor='',largura='470',mascara='',site='1',ordenacao='11',obrigatorio='0'
						WHERE id_servico_campo='1522';
--12/05/2010 11:23:16
UPDATE vsites_servico_campo SET campo='certidao_finalidade',tipo='text',nome='FINALIDADE',valor='',largura='470',mascara='',site='1',ordenacao='12',obrigatorio='0'
						WHERE id_servico_campo='1526';
--12/05/2010 11:23:16
UPDATE vsites_servico_campo SET campo='certidao_registro',tipo='text',nome='REGISTRO',valor='',largura='470',mascara='',site='1',ordenacao='13',obrigatorio='0'
						WHERE id_servico_campo='1523';
--12/05/2010 11:23:16
UPDATE vsites_servico_campo SET campo='certidao_data_registro',tipo='text',nome='DATA DO REGISTRO',valor='',largura='470',mascara='',site='1',ordenacao='14',obrigatorio='0'
						WHERE id_servico_campo='1524';
--12/05/2010 11:23:16
UPDATE vsites_servico_campo SET campo='certidao_protocolo',tipo='text',nome='PROTOCOLO',valor='',largura='470',mascara='',site='0',ordenacao='15',obrigatorio='0'
						WHERE id_servico_campo='1525';
--12/05/2010 11:23:16
DELETE FROM vsites_servico_campo WHERE id_servico_campo = '' AND id_servico='177';
--12/05/2010 11:24:47
UPDATE vsites_servico SET dias='', status='Ativo', descricao='Histórico Escolar', `vsites_servico_var` site='1' WHERE id_servico='110';
--12/05/2010 11:24:47
UPDATE vsites_servico_campo SET campo='certidao_nome',tipo='text',nome='NOME',valor='',largura='470',mascara='',site='1',ordenacao='1',obrigatorio='1'
						WHERE id_servico_campo='771';
--12/05/2010 11:24:47
UPDATE vsites_servico_campo SET campo='certidao_mae',tipo='text',nome='MAE',valor='',largura='470',mascara='',site='1',ordenacao='2',obrigatorio='1'
						WHERE id_servico_campo='649';
--12/05/2010 11:24:47
UPDATE vsites_servico_campo SET campo='certidao_pai',tipo='text',nome='PAI',valor='',largura='470',mascara='',site='1',ordenacao='3',obrigatorio='0'
						WHERE id_servico_campo='915';
--12/05/2010 11:24:47
UPDATE vsites_servico_campo SET campo='certidao_data_nascimento',tipo='text',nome='DATA DE NASCIMENTO',valor='',largura='470',mascara='',site='1',ordenacao='4',obrigatorio='1'
						WHERE id_servico_campo='397';
--12/05/2010 11:24:47
UPDATE vsites_servico_campo SET campo='certidao_nome_escola',tipo='text',nome='NOME DA ESCOLA',valor='',largura='470',mascara='',site='1',ordenacao='5',obrigatorio='1'
						WHERE id_servico_campo='825';
--12/05/2010 11:24:47
UPDATE vsites_servico_campo SET campo='certidao_endereco',tipo='text',nome='ENDERECO',valor='',largura='470',mascara='',site='1',ordenacao='6',obrigatorio='0'
						WHERE id_servico_campo='437';
--12/05/2010 11:24:47
UPDATE vsites_servico_campo SET campo='certidao_cidade',tipo='text',nome='CIDADE',valor='',largura='470',mascara='',site='1',ordenacao='7',obrigatorio='1'
						WHERE id_servico_campo='1505';
--12/05/2010 11:24:47
UPDATE vsites_servico_campo SET campo='certidao_estado',tipo='text',nome='ESTADO',valor='',largura='470',mascara='',site='1',ordenacao='8',obrigatorio='1'
						WHERE id_servico_campo='1506';
--12/05/2010 11:24:47
UPDATE vsites_servico_campo SET campo='certidao_historico_ano',tipo='text',nome='ANO DE CONCLUSÃO',valor='',largura='470',mascara='',site='1',ordenacao='9',obrigatorio='1'
						WHERE id_servico_campo='1';
--12/05/2010 11:24:47
UPDATE vsites_servico_campo SET campo='certidao_serie',tipo='text',nome='SERIE',valor='',largura='470',mascara='',site='1',ordenacao='10',obrigatorio='1'
						WHERE id_servico_campo='1211';
--12/05/2010 11:24:47
DELETE FROM vsites_servico_campo WHERE id_servico_campo = '' AND id_servico='110';
--12/05/2010 11:26:40
UPDATE vsites_servico SET dias='', status='Ativo', descricao='Averbação - Retificação', `vsites_servico_var` site='1' WHERE id_servico='54';
--12/05/2010 11:26:40
UPDATE vsites_servico_campo SET campo='certidao_nome',tipo='text',nome='NOME',valor='',largura='470',mascara='',site='1',ordenacao='1',obrigatorio='1'
						WHERE id_servico_campo='731';
--12/05/2010 11:26:40
UPDATE vsites_servico_campo SET campo='certidao_conjuge',tipo='text',nome='CONJUGE',valor='',largura='470',mascara='',site='1',ordenacao='2',obrigatorio='0'
						WHERE id_servico_campo='274';
--12/05/2010 11:26:40
UPDATE vsites_servico_campo SET campo='certidao_mae',tipo='text',nome='MAE',valor='',largura='470',mascara='',site='1',ordenacao='3',obrigatorio='0'
						WHERE id_servico_campo='640';
--12/05/2010 11:26:40
UPDATE vsites_servico_campo SET campo='certidao_pai',tipo='text',nome='PAI',valor='',largura='470',mascara='',site='1',ordenacao='4',obrigatorio='0'
						WHERE id_servico_campo='906';
--12/05/2010 11:26:40
UPDATE vsites_servico_campo SET campo='certidao_data_nascimento',tipo='text',nome='DATA DE NASCIMENTO',valor='',largura='470',mascara='',site='1',ordenacao='5',obrigatorio='0'
						WHERE id_servico_campo='385';
--12/05/2010 11:26:40
UPDATE vsites_servico_campo SET campo='certidao_data_casamento',tipo='text',nome='DATA DE CASAMENTO',valor='',largura='470',mascara='',site='1',ordenacao='6',obrigatorio='0'
						WHERE id_servico_campo='363';
--12/05/2010 11:26:40
UPDATE vsites_servico_campo SET campo='certidao_livro',tipo='text',nome='LIVRO',valor='',largura='470',mascara='',site='1',ordenacao='7',obrigatorio='0'
						WHERE id_servico_campo='618';
--12/05/2010 11:26:40
UPDATE vsites_servico_campo SET campo='certidao_folha',tipo='text',nome='FOLHA',valor='',largura='470',mascara='',site='1',ordenacao='8',obrigatorio='0'
						WHERE id_servico_campo='595';
--12/05/2010 11:26:40
UPDATE vsites_servico_campo SET campo='certidao_registro',tipo='text',nome='REGISTRO',valor='',largura='470',mascara='',site='1',ordenacao='9',obrigatorio='0'
						WHERE id_servico_campo='1043';
--12/05/2010 11:26:40
UPDATE vsites_servico_campo SET campo='certidao_data_registro',tipo='text',nome='DATA DO REGISTRO',valor='',largura='470',mascara='',site='1',ordenacao='10',obrigatorio='0'
						WHERE id_servico_campo='418';
--12/05/2010 11:26:40
UPDATE vsites_servico_campo SET campo='certidao_cidade',tipo='text',nome='CIDADE',valor='',largura='470',mascara='',site='1',ordenacao='11',obrigatorio='1'
						WHERE id_servico_campo='108';
--12/05/2010 11:26:40
UPDATE vsites_servico_campo SET campo='certidao_estado',tipo='text',nome='ESTADO',valor='',largura='470',mascara='',site='1',ordenacao='12',obrigatorio='1'
						WHERE id_servico_campo='474';
--12/05/2010 11:26:40
UPDATE vsites_servico_campo SET campo='certidao_cartorio',tipo='text',nome='CARTORIO',valor='',largura='470',mascara='',site='1',ordenacao='13',obrigatorio='0'
						WHERE id_servico_campo='27';
--12/05/2010 11:26:40
UPDATE vsites_servico_campo SET campo='certidao_averbacao',tipo='text',nome='AVERBACAO',valor='',largura='470',mascara='',site='1',ordenacao='14',obrigatorio='0'
						WHERE id_servico_campo='4';
--12/05/2010 11:26:40
UPDATE vsites_servico_campo SET campo='certidao_finalidade',tipo='text',nome='FINALIDADE DO DOCUMENTO',valor='',largura='470',mascara='',site='1',ordenacao='15',obrigatorio='0'
						WHERE id_servico_campo='576';
--12/05/2010 11:26:40
DELETE FROM vsites_servico_campo WHERE id_servico_campo = '' AND id_servico='54';
--12/05/2010 11:29:16
UPDATE vsites_servico SET dias='', status='Ativo', descricao='Averbação - Divórcio', `vsites_servico_var` site='1' WHERE id_servico='29';
--12/05/2010 11:29:16
UPDATE vsites_servico_campo SET campo='certidao_nome',tipo='text',nome='NOME',valor='',largura='470',mascara='',site='1',ordenacao='1',obrigatorio='1'
						WHERE id_servico_campo='730';
--12/05/2010 11:29:16
UPDATE vsites_servico_campo SET campo='certidao_conjuge',tipo='text',nome='CONJUGE',valor='',largura='470',mascara='',site='1',ordenacao='2',obrigatorio='1'
						WHERE id_servico_campo='273';
--12/05/2010 11:29:16
UPDATE vsites_servico_campo SET campo='certidao_data_casamento',tipo='text',nome='DATA DE CASAMENTO',valor='',largura='470',mascara='',site='1',ordenacao='3',obrigatorio='1'
						WHERE id_servico_campo='362';
--12/05/2010 11:29:16
UPDATE vsites_servico_campo SET campo='certidao_livro',tipo='text',nome='LIVRO',valor='',largura='470',mascara='',site='1',ordenacao='4',obrigatorio='0'
						WHERE id_servico_campo='617';
--12/05/2010 11:29:16
UPDATE vsites_servico_campo SET campo='certidao_folha',tipo='text',nome='FOLHA',valor='',largura='470',mascara='',site='1',ordenacao='5',obrigatorio='0'
						WHERE id_servico_campo='594';
--12/05/2010 11:29:16
UPDATE vsites_servico_campo SET campo='certidao_registro',tipo='text',nome='REGISTRO',valor='',largura='470',mascara='',site='1',ordenacao='6',obrigatorio='0'
						WHERE id_servico_campo='1042';
--12/05/2010 11:29:16
UPDATE vsites_servico_campo SET campo='certidao_cidade',tipo='text',nome='CIDADE',valor='',largura='470',mascara='',site='1',ordenacao='7',obrigatorio='1'
						WHERE id_servico_campo='107';
--12/05/2010 11:29:16
UPDATE vsites_servico_campo SET campo='certidao_estado',tipo='text',nome='ESTADO',valor='',largura='470',mascara='',site='1',ordenacao='8',obrigatorio='1'
						WHERE id_servico_campo='473';
--12/05/2010 11:29:16
UPDATE vsites_servico_campo SET campo='certidao_cartorio',tipo='text',nome='CARTORIO',valor='',largura='470',mascara='',site='1',ordenacao='9',obrigatorio='0'
						WHERE id_servico_campo='26';
--12/05/2010 11:29:16
UPDATE vsites_servico_campo SET campo='certidao_averbacao',tipo='text',nome='AVERBACAO',valor='',largura='470',mascara='',site='1',ordenacao='10',obrigatorio='0'
						WHERE id_servico_campo='3';
--12/05/2010 11:29:16
UPDATE vsites_servico_campo SET campo='certidao_finalidade',tipo='text',nome='FINALIDADE DO DOCUMENTO',valor='',largura='470',mascara='',site='1',ordenacao='11',obrigatorio='0'
						WHERE id_servico_campo='575';
--12/05/2010 11:29:16
DELETE FROM vsites_servico_campo WHERE id_servico_campo = '' AND id_servico='29';
--12/05/2010 11:31:04
UPDATE vsites_servico SET dias='', status='Ativo', descricao='Anotação - Óbito', `vsites_servico_var` site='1' WHERE id_servico='30';
--12/05/2010 11:31:04
UPDATE vsites_servico_campo SET campo='certidao_nome',tipo='text',nome='NOME',valor='',largura='470',mascara='',site='1',ordenacao='1',obrigatorio='1'
						WHERE id_servico_campo='728';
--12/05/2010 11:31:04
UPDATE vsites_servico_campo SET campo='certidao_data_nascimento',tipo='text',nome='DATA DE NASCIMENTO',valor='',largura='470',mascara='',site='1',ordenacao='2',obrigatorio='0'
						WHERE id_servico_campo='1504';
--12/05/2010 11:31:04
UPDATE vsites_servico_campo SET campo='certidao_cidade',tipo='text',nome='CIDADE',valor='',largura='470',mascara='',site='1',ordenacao='3',obrigatorio='1'
						WHERE id_servico_campo='105';
--12/05/2010 11:31:04
UPDATE vsites_servico_campo SET campo='certidao_estado',tipo='text',nome='ESTADO',valor='',largura='470',mascara='',site='1',ordenacao='4',obrigatorio='1'
						WHERE id_servico_campo='471';
--12/05/2010 11:31:04
UPDATE vsites_servico_campo SET campo='certidao_mae',tipo='text',nome='MAE',valor='',largura='470',mascara='',site='1',ordenacao='5',obrigatorio='0'
						WHERE id_servico_campo='638';
--12/05/2010 11:31:04
UPDATE vsites_servico_campo SET campo='certidao_pai',tipo='text',nome='PAI',valor='',largura='470',mascara='',site='1',ordenacao='6',obrigatorio='0'
						WHERE id_servico_campo='904';
--12/05/2010 11:31:04
UPDATE vsites_servico_campo SET campo='certidao_conjuge',tipo='text',nome='CONJUGE',valor='',largura='470',mascara='',site='1',ordenacao='7',obrigatorio='0'
						WHERE id_servico_campo='272';
--12/05/2010 11:31:04
UPDATE vsites_servico_campo SET campo='certidao_data_casamento',tipo='text',nome='DATA DE CASAMENTO',valor='',largura='470',mascara='',site='1',ordenacao='8',obrigatorio='0'
						WHERE id_servico_campo='369';
--12/05/2010 11:31:04
UPDATE vsites_servico_campo SET campo='certidao_cartorio',tipo='text',nome='CARTÓRIO',valor='',largura='470',mascara='',site='1',ordenacao='9',obrigatorio='0'
						WHERE id_servico_campo='82';
--12/05/2010 11:31:04
UPDATE vsites_servico_campo SET campo='certidao_livro',tipo='text',nome='LIVRO',valor='',largura='470',mascara='',site='1',ordenacao='10',obrigatorio='0'
						WHERE id_servico_campo='616';
--12/05/2010 11:31:04
UPDATE vsites_servico_campo SET campo='certidao_folha',tipo='text',nome='FOLHA',valor='',largura='470',mascara='',site='1',ordenacao='11',obrigatorio='0'
						WHERE id_servico_campo='592';
--12/05/2010 11:31:04
UPDATE vsites_servico_campo SET campo='certidao_averbacao',tipo='text',nome='AVERBACAO',valor='',largura='470',mascara='',site='1',ordenacao='12',obrigatorio='0'
						WHERE id_servico_campo='2';
--12/05/2010 11:31:04
UPDATE vsites_servico_campo SET campo='certidao_registro',tipo='text',nome='REGISTRO',valor='',largura='470',mascara='',site='1',ordenacao='13',obrigatorio='0'
						WHERE id_servico_campo='1041';
--12/05/2010 11:31:04
INSERT INTO vsites_servico_campo (id_servico, campo, nome, tipo, largura, site, ordenacao) VALUES ('30','certidao_data_registro','DATA REGISTRO','text','470','1','14');
--12/05/2010 11:31:04
UPDATE vsites_servico_campo SET campo='certidao_finalidade',tipo='text',nome='FINALIDADE DO DOCUMENTO',valor='',largura='470',mascara='',site='1',ordenacao='15',obrigatorio='0'
						WHERE id_servico_campo='574';
--12/05/2010 11:31:04
DELETE FROM vsites_servico_campo WHERE id_servico_campo = '' AND id_servico='30';
--12/05/2010 11:34:33
UPDATE vsites_servico SET dias='', status='Ativo', descricao='Anotação - Óbito', `vsites_servico_var` site='1' WHERE id_servico='30';
--12/05/2010 11:34:33
UPDATE vsites_servico_campo SET campo='certidao_nome',tipo='text',nome='NOME',valor='',largura='470',mascara='',site='1',ordenacao='1',obrigatorio='1'
						WHERE id_servico_campo='728';
--12/05/2010 11:34:33
UPDATE vsites_servico_campo SET campo='certidao_conjuge',tipo='text',nome='CONJUGE',valor='',largura='470',mascara='',site='1',ordenacao='2',obrigatorio='0'
						WHERE id_servico_campo='272';
--12/05/2010 11:34:33
UPDATE vsites_servico_campo SET campo='certidao_mae',tipo='text',nome='MAE',valor='',largura='470',mascara='',site='1',ordenacao='3',obrigatorio='0'
						WHERE id_servico_campo='638';
--12/05/2010 11:34:33
UPDATE vsites_servico_campo SET campo='certidao_pai',tipo='text',nome='PAI',valor='',largura='470',mascara='',site='1',ordenacao='4',obrigatorio='0'
						WHERE id_servico_campo='904';
--12/05/2010 11:34:33
UPDATE vsites_servico_campo SET campo='certidao_data_casamento',tipo='text',nome='DATA DE CASAMENTO',valor='',largura='470',mascara='',site='1',ordenacao='5',obrigatorio='0'
						WHERE id_servico_campo='369';
--12/05/2010 11:34:33
UPDATE vsites_servico_campo SET campo='certidao_data_nascimento',tipo='text',nome='DATA DE NASCIMENTO',valor='',largura='470',mascara='',site='1',ordenacao='6',obrigatorio='0'
						WHERE id_servico_campo='1504';
--12/05/2010 11:34:33
UPDATE vsites_servico_campo SET campo='certidao_livro',tipo='text',nome='LIVRO',valor='',largura='470',mascara='',site='1',ordenacao='7',obrigatorio='0'
						WHERE id_servico_campo='616';
--12/05/2010 11:34:33
UPDATE vsites_servico_campo SET campo='certidao_folha',tipo='text',nome='FOLHA',valor='',largura='470',mascara='',site='1',ordenacao='8',obrigatorio='0'
						WHERE id_servico_campo='592';
--12/05/2010 11:34:33
UPDATE vsites_servico_campo SET campo='certidao_registro',tipo='text',nome='REGISTRO',valor='',largura='470',mascara='',site='1',ordenacao='9',obrigatorio='0'
						WHERE id_servico_campo='1041';
--12/05/2010 11:34:33
UPDATE vsites_servico_campo SET campo='certidao_data_registro',tipo='text',nome='DATA REGISTRO',valor='',largura='470',mascara='',site='1',ordenacao='10',obrigatorio='0'
						WHERE id_servico_campo='1594';
--12/05/2010 11:34:33
UPDATE vsites_servico_campo SET campo='certidao_cidade',tipo='text',nome='CIDADE',valor='',largura='470',mascara='',site='1',ordenacao='11',obrigatorio='1'
						WHERE id_servico_campo='105';
--12/05/2010 11:34:33
UPDATE vsites_servico_campo SET campo='certidao_estado',tipo='text',nome='ESTADO',valor='',largura='470',mascara='',site='1',ordenacao='12',obrigatorio='1'
						WHERE id_servico_campo='471';
--12/05/2010 11:34:33
UPDATE vsites_servico_campo SET campo='certidao_cartorio',tipo='text',nome='CARTÓRIO',valor='',largura='470',mascara='',site='1',ordenacao='13',obrigatorio='0'
						WHERE id_servico_campo='82';
--12/05/2010 11:34:33
UPDATE vsites_servico_campo SET campo='certidao_averbacao',tipo='text',nome='AVERBACAO',valor='',largura='470',mascara='',site='1',ordenacao='14',obrigatorio='0'
						WHERE id_servico_campo='2';
--12/05/2010 11:34:33
UPDATE vsites_servico_campo SET campo='certidao_finalidade',tipo='text',nome='FINALIDADE DO DOCUMENTO',valor='',largura='470',mascara='',site='1',ordenacao='15',obrigatorio='0'
						WHERE id_servico_campo='574';
--12/05/2010 11:34:33
DELETE FROM vsites_servico_campo WHERE id_servico_campo = '' AND id_servico='30';
--12/05/2010 11:43:18
UPDATE vsites_servico SET dias='', status='Ativo', descricao='Casamento', site='1' WHERE id_servico='3';
--12/05/2010 11:43:18
UPDATE vsites_servico_campo SET campo='certidao_nome',tipo='text',nome='NOME',valor='',largura='470',mascara='',site='1',ordenacao='1',obrigatorio='1'
						WHERE id_servico_campo='745';
--12/05/2010 11:43:18
UPDATE vsites_servico_campo SET campo='certidao_esposa',tipo='text',nome='CONJUGUE',valor='',largura='470',mascara='',site='1',ordenacao='2',obrigatorio='1'
						WHERE id_servico_campo='464';
--12/05/2010 11:43:18
UPDATE vsites_servico_campo SET campo='certidao_data_casamento',tipo='text',nome='DATA DE CASAMENTO',valor='',largura='470',mascara='',site='1',ordenacao='3',obrigatorio='1'
						WHERE id_servico_campo='364';
--12/05/2010 11:43:18
UPDATE vsites_servico_campo SET campo='certidao_livro',tipo='text',nome='LIVRO',valor='',largura='470',mascara='',site='1',ordenacao='4',obrigatorio='0'
						WHERE id_servico_campo='619';
--12/05/2010 11:43:18
UPDATE vsites_servico_campo SET campo='certidao_folha',tipo='text',nome='FOLHA',valor='',largura='470',mascara='',site='1',ordenacao='5',obrigatorio='0'
						WHERE id_servico_campo='596';
--12/05/2010 11:43:18
UPDATE vsites_servico_campo SET campo='certidao_registro',tipo='text',nome='REGISTRO',valor='',largura='470',mascara='',site='1',ordenacao='6',obrigatorio='0'
						WHERE id_servico_campo='1044';
--12/05/2010 11:43:18
UPDATE vsites_servico_campo SET campo='certidao_cidade',tipo='text',nome='CIDADE',valor='',largura='470',mascara='',site='1',ordenacao='7',obrigatorio='1'
						WHERE id_servico_campo='122';
--12/05/2010 11:43:18
UPDATE vsites_servico_campo SET campo='certidao_estado',tipo='text',nome='ESTADO',valor='',largura='470',mascara='',site='1',ordenacao='8',obrigatorio='1'
						WHERE id_servico_campo='488';
--12/05/2010 11:43:18
UPDATE vsites_servico_campo SET campo='certidao_averbacao',tipo='text',nome='AVERBACAO',valor='',largura='470',mascara='',site='1',ordenacao='9',obrigatorio='0'
						WHERE id_servico_campo='5';
--12/05/2010 11:43:18
UPDATE vsites_servico_campo SET campo='certidao_cartorio',tipo='text',nome='CARTORIO',valor='',largura='470',mascara='',site='1',ordenacao='10',obrigatorio='0'
						WHERE id_servico_campo='34';
--12/05/2010 11:43:18
UPDATE vsites_servico_campo SET campo='certidao_finalidade',tipo='text',nome='FINALIDADE DO DOCUMENTO',valor='',largura='470',mascara='',site='1',ordenacao='11',obrigatorio='0'
						WHERE id_servico_campo='578';
--12/05/2010 11:43:18
DELETE FROM vsites_servico_campo WHERE id_servico_campo = '' AND id_servico='3';
--12/05/2010 11:43:50
UPDATE vsites_servico SET dias='', status='Ativo', descricao='Casamento', site='1' WHERE id_servico='3';
--12/05/2010 11:43:50
UPDATE vsites_servico_campo SET campo='certidao_nome',tipo='text',nome='NOME',valor='',largura='470',mascara='',site='1',ordenacao='1',obrigatorio='1'
						WHERE id_servico_campo='745';
--12/05/2010 11:43:50
UPDATE vsites_servico_campo SET campo='certidao_esposa',tipo='text',nome='CONJUGE',valor='',largura='470',mascara='',site='1',ordenacao='2',obrigatorio='1'
						WHERE id_servico_campo='464';
--12/05/2010 11:43:50
UPDATE vsites_servico_campo SET campo='certidao_data_casamento',tipo='text',nome='DATA DE CASAMENTO',valor='',largura='470',mascara='',site='1',ordenacao='3',obrigatorio='1'
						WHERE id_servico_campo='364';
--12/05/2010 11:43:50
UPDATE vsites_servico_campo SET campo='certidao_livro',tipo='text',nome='LIVRO',valor='',largura='470',mascara='',site='1',ordenacao='4',obrigatorio='0'
						WHERE id_servico_campo='619';
--12/05/2010 11:43:50
UPDATE vsites_servico_campo SET campo='certidao_folha',tipo='text',nome='FOLHA',valor='',largura='470',mascara='',site='1',ordenacao='5',obrigatorio='0'
						WHERE id_servico_campo='596';
--12/05/2010 11:43:50
UPDATE vsites_servico_campo SET campo='certidao_registro',tipo='text',nome='REGISTRO',valor='',largura='470',mascara='',site='1',ordenacao='6',obrigatorio='0'
						WHERE id_servico_campo='1044';
--12/05/2010 11:43:50
UPDATE vsites_servico_campo SET campo='certidao_cidade',tipo='text',nome='CIDADE',valor='',largura='470',mascara='',site='1',ordenacao='7',obrigatorio='1'
						WHERE id_servico_campo='122';
--12/05/2010 11:43:50
UPDATE vsites_servico_campo SET campo='certidao_estado',tipo='text',nome='ESTADO',valor='',largura='470',mascara='',site='1',ordenacao='8',obrigatorio='1'
						WHERE id_servico_campo='488';
--12/05/2010 11:43:50
UPDATE vsites_servico_campo SET campo='certidao_averbacao',tipo='text',nome='AVERBACAO',valor='',largura='470',mascara='',site='1',ordenacao='9',obrigatorio='0'
						WHERE id_servico_campo='5';
--12/05/2010 11:43:50
UPDATE vsites_servico_campo SET campo='certidao_cartorio',tipo='text',nome='CARTORIO',valor='',largura='470',mascara='',site='1',ordenacao='10',obrigatorio='0'
						WHERE id_servico_campo='34';
--12/05/2010 11:43:50
UPDATE vsites_servico_campo SET campo='certidao_finalidade',tipo='text',nome='FINALIDADE DO DOCUMENTO',valor='',largura='470',mascara='',site='1',ordenacao='11',obrigatorio='0'
						WHERE id_servico_campo='578';
--12/05/2010 11:43:50
DELETE FROM vsites_servico_campo WHERE id_servico_campo = '' AND id_servico='3';
--12/05/2010 15:09:58
UPDATE vsites_servico SET dias='', status='Inativo', descricao='digitalização', site='1' WHERE id_servico='143';
--12/05/2010 15:09:59
UPDATE vsites_servico_campo SET campo='certidao_folha',tipo='text',nome='FOLHA',valor='',largura='470',mascara='',site='1',ordenacao='1',obrigatorio='0'
						WHERE id_servico_campo='601';
--12/05/2010 15:09:59
DELETE FROM vsites_servico_campo WHERE id_servico_campo = '' AND id_servico='143';
--12/05/2010 17:00:21
UPDATE vsites_servico SET dias='', status='Inativo', descricao='Limpeza de Nome', site='1' WHERE id_servico='48';
--12/05/2010 17:00:21
UPDATE vsites_servico_campo SET campo='certidao_nome',tipo='text',nome='NOME',valor='',largura='470',mascara='',site='1',ordenacao='1',obrigatorio='1'
						WHERE id_servico_campo='783';
--12/05/2010 17:00:22
UPDATE vsites_servico_campo SET campo='certidao_rg',tipo='text',nome='RG',valor='',largura='470',mascara='',site='1',ordenacao='2',obrigatorio='0'
						WHERE id_servico_campo='1179';
--12/05/2010 17:00:22
UPDATE vsites_servico_campo SET campo='certidao_orgao_emissor',tipo='text',nome='ORGAO EMISSOR',valor='',largura='470',mascara='',site='1',ordenacao='3',obrigatorio='0'
						WHERE id_servico_campo='896';
--12/05/2010 17:00:22
UPDATE vsites_servico_campo SET campo='certidao_data_expedicao',tipo='text',nome='DATA DE EXPEDICAO',valor='',largura='470',mascara='',site='1',ordenacao='4',obrigatorio='0'
						WHERE id_servico_campo='378';
--12/05/2010 17:00:22
UPDATE vsites_servico_campo SET campo='certidao_cpf',tipo='text',nome='CPF',valor='',largura='470',mascara='',site='1',ordenacao='5',obrigatorio='0'
						WHERE id_servico_campo='326';
--12/05/2010 17:00:22
UPDATE vsites_servico_campo SET campo='certidao_cnpj',tipo='text',nome='CNPJ',valor='',largura='470',mascara='',site='1',ordenacao='6',obrigatorio='0'
						WHERE id_servico_campo='240';
--12/05/2010 17:00:22
UPDATE vsites_servico_campo SET campo='certidao_cidade',tipo='text',nome='CIDADE',valor='',largura='470',mascara='',site='1',ordenacao='7',obrigatorio='1'
						WHERE id_servico_campo='158';
--12/05/2010 17:00:22
UPDATE vsites_servico_campo SET campo='certidao_estado',tipo='text',nome='ESTADO',valor='',largura='470',mascara='',site='1',ordenacao='8',obrigatorio='1'
						WHERE id_servico_campo='523';
--12/05/2010 17:00:22
UPDATE vsites_servico_campo SET campo='certidao_cartorio',tipo='text',nome='CARTORIO',valor='',largura='470',mascara='',site='1',ordenacao='9',obrigatorio='0'
						WHERE id_servico_campo='50';
--12/05/2010 17:00:22
UPDATE vsites_servico_campo SET campo='certidao_protocolo',tipo='text',nome='PROTOCOLO',valor='',largura='470',mascara='',site='0',ordenacao='10',obrigatorio='0'
						WHERE id_servico_campo='997';
--12/05/2010 17:00:22
DELETE FROM vsites_servico_campo WHERE id_servico_campo = '' AND id_servico='48';
--14/05/2010 12:12:27
UPDATE vsites_servico SET dias='', status='Ativo', descricao='Pesquisa Detran', site='1' WHERE id_servico='16';
--14/05/2010 12:12:28
UPDATE vsites_servico_campo SET campo='certidao_nome',tipo='text',nome='NOME',valor='',largura='470',mascara='',site='1',ordenacao='1',obrigatorio='1'
						WHERE id_servico_campo='794';
--14/05/2010 12:12:28
UPDATE vsites_servico_campo SET campo='certidao_rg',tipo='text',nome='RG',valor='',largura='470',mascara='',site='1',ordenacao='2',obrigatorio='0'
						WHERE id_servico_campo='1189';
--14/05/2010 12:12:28
UPDATE vsites_servico_campo SET campo='certidao_cpf',tipo='text',nome='CPF',valor='',largura='470',mascara='',site='1',ordenacao='3',obrigatorio='0'
						WHERE id_servico_campo='333';
--14/05/2010 12:12:28
UPDATE vsites_servico_campo SET campo='certidao_cnpj',tipo='text',nome='CNPJ',valor='',largura='470',mascara='',site='1',ordenacao='4',obrigatorio='0'
						WHERE id_servico_campo='247';
--14/05/2010 12:12:28
UPDATE vsites_servico_campo SET campo='certidao_cidade',tipo='text',nome='CIDADE',valor='',largura='470',mascara='',site='1',ordenacao='5',obrigatorio='1'
						WHERE id_servico_campo='174';
--14/05/2010 12:12:28
UPDATE vsites_servico_campo SET campo='certidao_estado',tipo='text',nome='ESTADO',valor='',largura='470',mascara='',site='1',ordenacao='6',obrigatorio='1'
						WHERE id_servico_campo='538';
--14/05/2010 12:12:28
UPDATE vsites_servico_campo SET campo='certidao_protocolo',tipo='text',nome='PROTOCOLO',valor='',largura='470',mascara='',site='0',ordenacao='7',obrigatorio='0'
						WHERE id_servico_campo='1012';
--14/05/2010 12:12:28
INSERT INTO vsites_servico_campo (id_servico, campo, nome, tipo, largura, site, ordenacao) VALUES ('16','certidao_devedor','DEVEDOR','text','470','0','8');
--14/05/2010 12:12:28
INSERT INTO vsites_servico_campo (id_servico, campo, nome, tipo, largura, site, ordenacao) VALUES ('16','certidao_devedor_cpf','CPF DEVEDOR','text','470','0','9');
--14/05/2010 12:12:28
DELETE FROM vsites_servico_campo WHERE id_servico_campo = '' AND id_servico='16';
--18/05/2010 12:33:25
UPDATE vsites_servico SET dias='', status='Ativo', descricao='Batismo', site='1' WHERE id_servico='83';
--18/05/2010 12:33:25
UPDATE vsites_servico_campo SET campo='certidao_nome',tipo='text',nome='NOME',valor='',largura='470',mascara='',site='1',ordenacao='1',obrigatorio='1'
						WHERE id_servico_campo='735';
--18/05/2010 12:33:25
UPDATE vsites_servico_campo SET campo='certidao_mae',tipo='text',nome='MAE',valor='',largura='470',mascara='',site='1',ordenacao='2',obrigatorio='1'
						WHERE id_servico_campo='641';
--18/05/2010 12:33:25
UPDATE vsites_servico_campo SET campo='certidao_pai',tipo='text',nome='PAI',valor='',largura='470',mascara='',site='1',ordenacao='3',obrigatorio='0'
						WHERE id_servico_campo='907';
--18/05/2010 12:33:25
UPDATE vsites_servico_campo SET campo='certidao_data_batismo',tipo='text',nome='DATA DO BATISMO',valor='',largura='470',mascara='',site='1',ordenacao='4',obrigatorio='1'
						WHERE id_servico_campo='416';
--18/05/2010 12:33:25
UPDATE vsites_servico_campo SET campo='certidao_igreja',tipo='text',nome='IGREJA',valor='',largura='470',mascara='',site='1',ordenacao='5',obrigatorio='1'
						WHERE id_servico_campo='1544';
--18/05/2010 12:33:26
UPDATE vsites_servico_campo SET campo='certidao_cidade',tipo='text',nome='CIDADE',valor='',largura='470',mascara='',site='1',ordenacao='6',obrigatorio='1'
						WHERE id_servico_campo='113';
--18/05/2010 12:33:26
UPDATE vsites_servico_campo SET campo='certidao_estado',tipo='text',nome='ESTADO',valor='',largura='470',mascara='',site='1',ordenacao='7',obrigatorio='1'
						WHERE id_servico_campo='479';
--18/05/2010 12:33:26
UPDATE vsites_servico_campo SET campo='certidao_padre',tipo='text',nome='PADRE',valor='',largura='470',mascara='',site='1',ordenacao='8',obrigatorio='0'
						WHERE id_servico_campo='903';
--18/05/2010 12:33:26
DELETE FROM vsites_servico_campo WHERE id_servico_campo = '' AND id_servico='83';
--18/05/2010 12:35:13
UPDATE vsites_servico SET dias='', status='Ativo', descricao='Casamento', site='1' WHERE id_servico='3';
--18/05/2010 12:35:13
UPDATE vsites_servico_campo SET campo='certidao_nome',tipo='text',nome='NOME',valor='',largura='470',mascara='',site='1',ordenacao='1',obrigatorio='1'
						WHERE id_servico_campo='745';
--18/05/2010 12:35:14
UPDATE vsites_servico_campo SET campo='certidao_esposa',tipo='text',nome='ESPOSA/ESPOSO',valor='',largura='470',mascara='',site='1',ordenacao='2',obrigatorio='1'
						WHERE id_servico_campo='464';
--18/05/2010 12:35:14
UPDATE vsites_servico_campo SET campo='certidao_data_casamento',tipo='text',nome='DATA DE CASAMENTO',valor='',largura='470',mascara='',site='1',ordenacao='3',obrigatorio='1'
						WHERE id_servico_campo='364';
--18/05/2010 12:35:14
UPDATE vsites_servico_campo SET campo='certidao_livro',tipo='text',nome='LIVRO',valor='',largura='470',mascara='',site='1',ordenacao='4',obrigatorio='0'
						WHERE id_servico_campo='619';
--18/05/2010 12:35:14
UPDATE vsites_servico_campo SET campo='certidao_folha',tipo='text',nome='FOLHA',valor='',largura='470',mascara='',site='1',ordenacao='5',obrigatorio='0'
						WHERE id_servico_campo='596';
--18/05/2010 12:35:14
UPDATE vsites_servico_campo SET campo='certidao_registro',tipo='text',nome='REGISTRO',valor='',largura='470',mascara='',site='1',ordenacao='6',obrigatorio='0'
						WHERE id_servico_campo='1044';
--18/05/2010 12:35:14
UPDATE vsites_servico_campo SET campo='certidao_cidade',tipo='text',nome='CIDADE',valor='',largura='470',mascara='',site='1',ordenacao='7',obrigatorio='1'
						WHERE id_servico_campo='122';
--18/05/2010 12:35:14
UPDATE vsites_servico_campo SET campo='certidao_estado',tipo='text',nome='ESTADO',valor='',largura='470',mascara='',site='1',ordenacao='8',obrigatorio='1'
						WHERE id_servico_campo='488';
--18/05/2010 12:35:14
UPDATE vsites_servico_campo SET campo='certidao_averbacao',tipo='text',nome='AVERBACAO',valor='',largura='470',mascara='',site='1',ordenacao='9',obrigatorio='0'
						WHERE id_servico_campo='5';
--18/05/2010 12:35:14
UPDATE vsites_servico_campo SET campo='certidao_cartorio',tipo='text',nome='CARTORIO',valor='',largura='470',mascara='',site='1',ordenacao='10',obrigatorio='0'
						WHERE id_servico_campo='34';
--18/05/2010 12:35:14
UPDATE vsites_servico_campo SET campo='certidao_finalidade',tipo='text',nome='FINALIDADE DO DOCUMENTO',valor='',largura='470',mascara='',site='1',ordenacao='11',obrigatorio='0'
						WHERE id_servico_campo='578';
--18/05/2010 12:35:14
DELETE FROM vsites_servico_campo WHERE id_servico_campo = '' AND id_servico='3';
--18/05/2010 12:37:06
UPDATE vsites_servico SET dias='', status='Ativo', descricao='Nascimento', site='1' WHERE id_servico='2';
--18/05/2010 12:37:06
UPDATE vsites_servico_campo SET campo='certidao_nome',tipo='text',nome='NOME',valor='',largura='470',mascara='',site='1',ordenacao='1',obrigatorio='1'
						WHERE id_servico_campo='785';
--18/05/2010 12:37:06
UPDATE vsites_servico_campo SET campo='certidao_pai',tipo='text',nome='PAI',valor='',largura='470',mascara='',site='1',ordenacao='2',obrigatorio='0'
						WHERE id_servico_campo='921';
--18/05/2010 12:37:06
UPDATE vsites_servico_campo SET campo='certidao_mae',tipo='text',nome='MAE',valor='',largura='470',mascara='',site='1',ordenacao='3',obrigatorio='1'
						WHERE id_servico_campo='655';
--18/05/2010 12:37:06
UPDATE vsites_servico_campo SET campo='certidao_data_nascimento',tipo='text',nome='DATA DE NASCIMENTO',valor='',largura='470',mascara='',site='1',ordenacao='4',obrigatorio='1'
						WHERE id_servico_campo='404';
--18/05/2010 12:37:06
UPDATE vsites_servico_campo SET campo='certidao_livro',tipo='text',nome='LIVRO',valor='',largura='470',mascara='',site='1',ordenacao='5',obrigatorio='0'
						WHERE id_servico_campo='627';
--18/05/2010 12:37:06
UPDATE vsites_servico_campo SET campo='certidao_folha',tipo='text',nome='FOLHA',valor='',largura='470',mascara='',site='1',ordenacao='6',obrigatorio='0'
						WHERE id_servico_campo='605';
--18/05/2010 12:37:06
UPDATE vsites_servico_campo SET campo='certidao_registro',tipo='text',nome='REGISTRO',valor='',largura='470',mascara='',site='1',ordenacao='7',obrigatorio='0'
						WHERE id_servico_campo='1050';
--18/05/2010 12:37:06
UPDATE vsites_servico_campo SET campo='certidao_cidade',tipo='text',nome='CIDADE',valor='',largura='470',mascara='',site='1',ordenacao='8',obrigatorio='1'
						WHERE id_servico_campo='163';
--18/05/2010 12:37:06
UPDATE vsites_servico_campo SET campo='certidao_estado',tipo='text',nome='ESTADO',valor='',largura='470',mascara='',site='1',ordenacao='9',obrigatorio='1'
						WHERE id_servico_campo='527';
--18/05/2010 12:37:06
UPDATE vsites_servico_campo SET campo='certidao_cartorio',tipo='text',nome='CARTORIO',valor='',largura='470',mascara='',site='1',ordenacao='10',obrigatorio='0'
						WHERE id_servico_campo='54';
--18/05/2010 12:37:06
UPDATE vsites_servico_campo SET campo='certidao_cartorio_cep',tipo='text',nome='CEP DO CARTORIO',valor='',largura='470',mascara='',site='1',ordenacao='11',obrigatorio='0'
						WHERE id_servico_campo='98';
--18/05/2010 12:37:06
UPDATE vsites_servico_campo SET campo='certidao_data_registro',tipo='text',nome='DATA DO REGISTRO',valor='',largura='470',mascara='',site='1',ordenacao='12',obrigatorio='0'
						WHERE id_servico_campo='423';
--18/05/2010 12:37:06
UPDATE vsites_servico_campo SET campo='certidao_protocolo',tipo='text',nome='PROTOCOLO',valor='',largura='470',mascara='',site='0',ordenacao='13',obrigatorio='0'
						WHERE id_servico_campo='1001';
--18/05/2010 12:37:06
UPDATE vsites_servico_campo SET campo='certidao_averbacao',tipo='text',nome='AVERBACAO',valor='',largura='470',mascara='',site='1',ordenacao='14',obrigatorio='0'
						WHERE id_servico_campo='11';
--18/05/2010 12:37:07
UPDATE vsites_servico_campo SET campo='certidao_finalidade',tipo='text',nome='FINALIDADE DO DOCUMENTO',valor='',largura='470',mascara='',site='1',ordenacao='15',obrigatorio='0'
						WHERE id_servico_campo='584';
--18/05/2010 12:37:07
UPDATE vsites_servico_campo SET campo='certidao_tem_copia_doc',tipo='text',nome='TEM COPIA DO DOCUMENTO',valor='',largura='470',mascara='',site='1',ordenacao='16',obrigatorio='0'
						WHERE id_servico_campo='1228';
--18/05/2010 12:37:07
DELETE FROM vsites_servico_campo WHERE id_servico_campo = '' AND id_servico='2';
--18/05/2010 12:38:20
UPDATE vsites_servico SET dias='', status='Ativo', descricao='Óbito', site='1' WHERE id_servico='4';
--18/05/2010 12:38:20
UPDATE vsites_servico_campo SET campo='certidao_nome',tipo='text',nome='NOME',valor='',largura='470',mascara='',site='1',ordenacao='1',obrigatorio='1'
						WHERE id_servico_campo='791';
--18/05/2010 12:38:20
UPDATE vsites_servico_campo SET campo='certidao_mae',tipo='text',nome='MAE',valor='',largura='470',mascara='',site='1',ordenacao='2',obrigatorio='0'
						WHERE id_servico_campo='657';
--18/05/2010 12:38:20
UPDATE vsites_servico_campo SET campo='certidao_pai',tipo='text',nome='PAI',valor='',largura='470',mascara='',site='1',ordenacao='3',obrigatorio='0'
						WHERE id_servico_campo='923';
--18/05/2010 12:38:20
UPDATE vsites_servico_campo SET campo='certidao_data_obito',tipo='text',nome='DATA DE OBITO',valor='',largura='470',mascara='',site='1',ordenacao='4',obrigatorio='1'
						WHERE id_servico_campo='413';
--18/05/2010 12:38:20
UPDATE vsites_servico_campo SET campo='certidao_livro',tipo='text',nome='LIVRO',valor='',largura='470',mascara='',site='1',ordenacao='5',obrigatorio='0'
						WHERE id_servico_campo='629';
--18/05/2010 12:38:20
UPDATE vsites_servico_campo SET campo='certidao_folha',tipo='text',nome='FOLHA',valor='',largura='470',mascara='',site='1',ordenacao='6',obrigatorio='0'
						WHERE id_servico_campo='607';
--18/05/2010 12:38:20
UPDATE vsites_servico_campo SET campo='certidao_termo',tipo='text',nome='TERMO',valor='',largura='470',mascara='',site='1',ordenacao='7',obrigatorio='0'
						WHERE id_servico_campo='1230';
--18/05/2010 12:38:20
UPDATE vsites_servico_campo SET campo='certidao_cidade',tipo='text',nome='CIDADE',valor='',largura='470',mascara='',site='1',ordenacao='8',obrigatorio='1'
						WHERE id_servico_campo='169';
--18/05/2010 12:38:20
UPDATE vsites_servico_campo SET campo='certidao_estado',tipo='text',nome='ESTADO',valor='',largura='470',mascara='',site='1',ordenacao='9',obrigatorio='1'
						WHERE id_servico_campo='533';
--18/05/2010 12:38:20
UPDATE vsites_servico_campo SET campo='certidao_cartorio',tipo='text',nome='CARTORIO',valor='',largura='470',mascara='',site='1',ordenacao='10',obrigatorio='0'
						WHERE id_servico_campo='59';
--18/05/2010 12:38:20
UPDATE vsites_servico_campo SET campo='certidao_cartorio_endereco',tipo='text',nome='ENDERECO DO CARTORIO',valor='',largura='470',mascara='',site='1',ordenacao='11',obrigatorio='0'
						WHERE id_servico_campo='460';
--18/05/2010 12:38:20
UPDATE vsites_servico_campo SET campo='certidao_registro',tipo='text',nome='REGISTRO',valor='',largura='470',mascara='',site='1',ordenacao='12',obrigatorio='0'
						WHERE id_servico_campo='1052';
--18/05/2010 12:38:20
UPDATE vsites_servico_campo SET campo='certidao_data_registro',tipo='text',nome='DATA DO REGISTRO',valor='',largura='470',mascara='',site='1',ordenacao='13',obrigatorio='0'
						WHERE id_servico_campo='425';
--18/05/2010 12:38:20
UPDATE vsites_servico_campo SET campo='certidao_protocolo',tipo='text',nome='PROTOCOLO',valor='',largura='470',mascara='',site='0',ordenacao='14',obrigatorio='0'
						WHERE id_servico_campo='1007';
--18/05/2010 12:38:20
UPDATE vsites_servico_campo SET campo='certidao_finalidade',tipo='text',nome='FINALIDADE DO DOCUMENTO',valor='',largura='470',mascara='',site='1',ordenacao='15',obrigatorio='0'
						WHERE id_servico_campo='586';
--18/05/2010 12:38:20
UPDATE vsites_servico_campo SET campo='certidao_averbacao',tipo='text',nome='AVERBACAO',valor='',largura='470',mascara='',site='1',ordenacao='16',obrigatorio='0'
						WHERE id_servico_campo='13';
--18/05/2010 12:38:20
DELETE FROM vsites_servico_campo WHERE id_servico_campo = '' AND id_servico='4';
--18/05/2010 12:38:45
UPDATE vsites_servico SET dias='', status='Ativo', descricao='Casamento', site='1' WHERE id_servico='3';
--18/05/2010 12:38:45
UPDATE vsites_servico_campo SET campo='certidao_nome',tipo='text',nome='NOME',valor='',largura='470',mascara='',site='1',ordenacao='1',obrigatorio='1'
						WHERE id_servico_campo='745';
--18/05/2010 12:38:45
UPDATE vsites_servico_campo SET campo='certidao_esposa',tipo='text',nome='ESPOSA/ESPOSO',valor='',largura='470',mascara='',site='1',ordenacao='2',obrigatorio='1'
						WHERE id_servico_campo='464';
--18/05/2010 12:38:45
UPDATE vsites_servico_campo SET campo='certidao_data_casamento',tipo='text',nome='DATA DE CASAMENTO',valor='',largura='470',mascara='',site='1',ordenacao='3',obrigatorio='1'
						WHERE id_servico_campo='364';
--18/05/2010 12:38:45
UPDATE vsites_servico_campo SET campo='certidao_livro',tipo='text',nome='LIVRO',valor='',largura='470',mascara='',site='1',ordenacao='4',obrigatorio='0'
						WHERE id_servico_campo='619';
--18/05/2010 12:38:45
UPDATE vsites_servico_campo SET campo='certidao_folha',tipo='text',nome='FOLHA',valor='',largura='470',mascara='',site='1',ordenacao='5',obrigatorio='0'
						WHERE id_servico_campo='596';
--18/05/2010 12:38:46
UPDATE vsites_servico_campo SET campo='certidao_registro',tipo='text',nome='REGISTRO',valor='',largura='470',mascara='',site='1',ordenacao='6',obrigatorio='0'
						WHERE id_servico_campo='1044';
--18/05/2010 12:38:46
UPDATE vsites_servico_campo SET campo='certidao_cidade',tipo='text',nome='CIDADE',valor='',largura='470',mascara='',site='1',ordenacao='7',obrigatorio='1'
						WHERE id_servico_campo='122';
--18/05/2010 12:38:46
UPDATE vsites_servico_campo SET campo='certidao_estado',tipo='text',nome='ESTADO',valor='',largura='470',mascara='',site='1',ordenacao='8',obrigatorio='1'
						WHERE id_servico_campo='488';
--18/05/2010 12:38:46
UPDATE vsites_servico_campo SET campo='certidao_averbacao',tipo='text',nome='AVERBACAO',valor='',largura='470',mascara='',site='1',ordenacao='9',obrigatorio='0'
						WHERE id_servico_campo='5';
--18/05/2010 12:38:46
UPDATE vsites_servico_campo SET campo='certidao_cartorio',tipo='text',nome='CARTORIO',valor='',largura='470',mascara='',site='1',ordenacao='10',obrigatorio='0'
						WHERE id_servico_campo='34';
--18/05/2010 12:38:46
UPDATE vsites_servico_campo SET campo='certidao_finalidade',tipo='text',nome='FINALIDADE DO DOCUMENTO',valor='',largura='470',mascara='',site='1',ordenacao='11',obrigatorio='0'
						WHERE id_servico_campo='578';
--18/05/2010 12:38:46
DELETE FROM vsites_servico_campo WHERE id_servico_campo = '' AND id_servico='3';
--18/05/2010 13:23:08
UPDATE vsites_servico SET dias='', status='Ativo', descricao='Inteiro Teor - Casamento', site='1' WHERE id_servico='10';
--18/05/2010 13:23:08
UPDATE vsites_servico_campo SET campo='certidao_nome',tipo='text',nome='NOME',valor='',largura='470',mascara='',site='1',ordenacao='1',obrigatorio='1'
						WHERE id_servico_campo='772';
--18/05/2010 13:23:09
UPDATE vsites_servico_campo SET campo='certidao_esposa',tipo='text',nome='ESPOSA/ESPOSO',valor='',largura='470',mascara='',site='1',ordenacao='2',obrigatorio='1'
						WHERE id_servico_campo='465';
--18/05/2010 13:23:09
UPDATE vsites_servico_campo SET campo='certidao_data_casamento',tipo='text',nome='DATA DE CASAMENTO',valor='',largura='470',mascara='',site='1',ordenacao='3',obrigatorio='1'
						WHERE id_servico_campo='365';
--18/05/2010 13:23:09
UPDATE vsites_servico_campo SET campo='certidao_livro',tipo='text',nome='LIVRO',valor='',largura='470',mascara='',site='1',ordenacao='4',obrigatorio='0'
						WHERE id_servico_campo='624';
--18/05/2010 13:23:09
UPDATE vsites_servico_campo SET campo='certidao_folha',tipo='text',nome='FOLHA',valor='',largura='470',mascara='',site='1',ordenacao='5',obrigatorio='0'
						WHERE id_servico_campo='602';
--18/05/2010 13:23:09
UPDATE vsites_servico_campo SET campo='certidao_registro',tipo='text',nome='REGISTRO',valor='',largura='470',mascara='',site='1',ordenacao='6',obrigatorio='0'
						WHERE id_servico_campo='1047';
--18/05/2010 13:23:09
UPDATE vsites_servico_campo SET campo='certidao_cidade',tipo='text',nome='CIDADE',valor='',largura='470',mascara='',site='1',ordenacao='7',obrigatorio='1'
						WHERE id_servico_campo='148';
--18/05/2010 13:23:09
UPDATE vsites_servico_campo SET campo='certidao_estado',tipo='text',nome='ESTADO',valor='',largura='470',mascara='',site='1',ordenacao='8',obrigatorio='1'
						WHERE id_servico_campo='512';
--18/05/2010 13:23:10
UPDATE vsites_servico_campo SET campo='certidao_averbacao',tipo='text',nome='AVERBACAO',valor='',largura='470',mascara='',site='1',ordenacao='9',obrigatorio='0'
						WHERE id_servico_campo='8';
--18/05/2010 13:23:10
UPDATE vsites_servico_campo SET campo='certidao_cartorio',tipo='text',nome='CARTORIO',valor='',largura='470',mascara='',site='1',ordenacao='10',obrigatorio='0'
						WHERE id_servico_campo='47';
--18/05/2010 13:23:10
UPDATE vsites_servico_campo SET campo='certidao_finalidade',tipo='text',nome='FINALIDADE DO DOCUMENTO',valor='',largura='470',mascara='',site='1',ordenacao='11',obrigatorio='0'
						WHERE id_servico_campo='581';
--18/05/2010 13:23:10
DELETE FROM vsites_servico_campo WHERE id_servico_campo = '' AND id_servico='10';
--18/05/2010 13:24:13
UPDATE vsites_servico SET dias='', status='Ativo', descricao='Inteiro Teor - Nascimento', site='1' WHERE id_servico='178';
--18/05/2010 13:24:13
UPDATE vsites_servico_campo SET campo='certidao_nome',tipo='text',nome='NOME',valor='',largura='470',mascara='',site='1',ordenacao='1',obrigatorio='1'
						WHERE id_servico_campo='1527';
--18/05/2010 13:24:13
UPDATE vsites_servico_campo SET campo='certidao_mae',tipo='text',nome='MÃE',valor='',largura='470',mascara='',site='1',ordenacao='2',obrigatorio='1'
						WHERE id_servico_campo='1531';
--18/05/2010 13:24:14
UPDATE vsites_servico_campo SET campo='certidao_pai',tipo='text',nome='PAI',valor='',largura='470',mascara='',site='1',ordenacao='3',obrigatorio='0'
						WHERE id_servico_campo='1532';
--18/05/2010 13:24:14
UPDATE vsites_servico_campo SET campo='certidao_data_nascimento',tipo='text',nome='DATA DE NASCIMENTO',valor='',largura='470',mascara='',site='1',ordenacao='4',obrigatorio='1'
						WHERE id_servico_campo='1528';
--18/05/2010 13:24:15
UPDATE vsites_servico_campo SET campo='certidao_livro',tipo='text',nome='LIVRO',valor='',largura='470',mascara='',site='1',ordenacao='5',obrigatorio='0'
						WHERE id_servico_campo='1533';
--18/05/2010 13:24:15
UPDATE vsites_servico_campo SET campo='certidao_folha',tipo='text',nome='FOLHA',valor='',largura='470',mascara='',site='1',ordenacao='6',obrigatorio='0'
						WHERE id_servico_campo='1534';
--18/05/2010 13:24:15
UPDATE vsites_servico_campo SET campo='certidao_registro',tipo='text',nome='REGISTRO',valor='',largura='470',mascara='',site='1',ordenacao='7',obrigatorio='0'
						WHERE id_servico_campo='1538';
--18/05/2010 13:24:16
UPDATE vsites_servico_campo SET campo='certidao_cidade',tipo='text',nome='CIDADE',valor='',largura='470',mascara='',site='1',ordenacao='8',obrigatorio='1'
						WHERE id_servico_campo='1529';
--18/05/2010 13:24:16
UPDATE vsites_servico_campo SET campo='certidao_estado',tipo='text',nome='ESTADO',valor='',largura='470',mascara='',site='1',ordenacao='9',obrigatorio='1'
						WHERE id_servico_campo='1530';
--18/05/2010 13:24:16
UPDATE vsites_servico_campo SET campo='certidao_cartorio',tipo='text',nome='CARTÓRIO',valor='',largura='470',mascara='',site='1',ordenacao='10',obrigatorio='0'
						WHERE id_servico_campo='1536';
--18/05/2010 13:24:17
UPDATE vsites_servico_campo SET campo='certidao_cartorio_cep',tipo='text',nome='CEP DO CARTÓRIO',valor='',largura='470',mascara='',site='1',ordenacao='11',obrigatorio='0'
						WHERE id_servico_campo='1537';
--18/05/2010 13:24:17
UPDATE vsites_servico_campo SET campo='certidao_data_registro',tipo='text',nome='DATA DO REGISTRO',valor='',largura='470',mascara='',site='1',ordenacao='12',obrigatorio='0'
						WHERE id_servico_campo='1539';
--18/05/2010 13:24:18
UPDATE vsites_servico_campo SET campo='certidao_protocolo',tipo='text',nome='PROTOCOLO',valor='',largura='470',mascara='',site='0',ordenacao='13',obrigatorio='0'
						WHERE id_servico_campo='1535';
--18/05/2010 13:24:18
UPDATE vsites_servico_campo SET campo='certidao_averbacao',tipo='text',nome='AVERBAÇÃO',valor='',largura='470',mascara='',site='1',ordenacao='14',obrigatorio='0'
						WHERE id_servico_campo='1540';
--18/05/2010 13:24:18
UPDATE vsites_servico_campo SET campo='certidao_finalidade',tipo='text',nome='FINALIDADE',valor='',largura='470',mascara='',site='1',ordenacao='15',obrigatorio='0'
						WHERE id_servico_campo='1541';
--18/05/2010 13:24:19
UPDATE vsites_servico_campo SET campo='certidao_tem_copia_doc',tipo='text',nome='TEM CÓPIA DO DOC',valor='',largura='470',mascara='',site='1',ordenacao='16',obrigatorio='0'
						WHERE id_servico_campo='1542';
--18/05/2010 13:24:20
DELETE FROM vsites_servico_campo WHERE id_servico_campo = '' AND id_servico='178';
--18/05/2010 13:25:34
UPDATE vsites_servico SET dias='', status='Ativo', descricao='Inteiro Teor - Óbito', site='1' WHERE id_servico='177';
--18/05/2010 13:25:34
UPDATE vsites_servico_campo SET campo='certidao_nome',tipo='text',nome='NOME',valor='',largura='470',mascara='',site='1',ordenacao='1',obrigatorio='1'
						WHERE id_servico_campo='1512';
--18/05/2010 13:25:34
UPDATE vsites_servico_campo SET campo='certidao_mae',tipo='text',nome='MÃE',valor='',largura='470',mascara='',site='1',ordenacao='2',obrigatorio='0'
						WHERE id_servico_campo='1515';
--18/05/2010 13:25:34
UPDATE vsites_servico_campo SET campo='certidao_pai',tipo='text',nome='PAI',valor='',largura='470',mascara='',site='1',ordenacao='3',obrigatorio='0'
						WHERE id_servico_campo='1516';
--18/05/2010 13:25:34
UPDATE vsites_servico_campo SET campo='certidao_data_obito',tipo='text',nome='DATA DE ÓBITO',valor='',largura='470',mascara='',site='1',ordenacao='4',obrigatorio='1'
						WHERE id_servico_campo='1517';
--18/05/2010 13:25:35
UPDATE vsites_servico_campo SET campo='certidao_livro',tipo='text',nome='LIVRO',valor='',largura='470',mascara='',site='1',ordenacao='5',obrigatorio='0'
						WHERE id_servico_campo='1518';
--18/05/2010 13:25:35
UPDATE vsites_servico_campo SET campo='certidao_folha',tipo='text',nome='FOLHA',valor='',largura='470',mascara='',site='1',ordenacao='6',obrigatorio='0'
						WHERE id_servico_campo='1519';
--18/05/2010 13:25:35
UPDATE vsites_servico_campo SET campo='certidao_termo',tipo='text',nome='TERMO',valor='',largura='470',mascara='',site='1',ordenacao='7',obrigatorio='0'
						WHERE id_servico_campo='1520';
--18/05/2010 13:25:35
UPDATE vsites_servico_campo SET campo='certidao_cidade',tipo='text',nome='CIDADE',valor='',largura='470',mascara='',site='1',ordenacao='8',obrigatorio='1'
						WHERE id_servico_campo='1513';
--18/05/2010 13:25:35
UPDATE vsites_servico_campo SET campo='certidao_estado',tipo='text',nome='ESTADO',valor='',largura='470',mascara='',site='1',ordenacao='9',obrigatorio='1'
						WHERE id_servico_campo='1514';
--18/05/2010 13:25:35
UPDATE vsites_servico_campo SET campo='certidao_cartorio',tipo='text',nome='CARTÓRIO',valor='',largura='470',mascara='',site='1',ordenacao='10',obrigatorio='0'
						WHERE id_servico_campo='1521';
--18/05/2010 13:25:36
UPDATE vsites_servico_campo SET campo='certidao_cartorio_endereco',tipo='text',nome='ENDEREÇO CARTÓRIO',valor='',largura='470',mascara='',site='1',ordenacao='11',obrigatorio='0'
						WHERE id_servico_campo='1522';
--18/05/2010 13:25:36
UPDATE vsites_servico_campo SET campo='certidao_registro',tipo='text',nome='REGISTRO',valor='',largura='470',mascara='',site='1',ordenacao='12',obrigatorio='0'
						WHERE id_servico_campo='1523';
--18/05/2010 13:25:36
UPDATE vsites_servico_campo SET campo='certidao_data_registro',tipo='text',nome='DATA DO REGISTRO',valor='',largura='470',mascara='',site='1',ordenacao='13',obrigatorio='0'
						WHERE id_servico_campo='1524';
--18/05/2010 13:25:36
UPDATE vsites_servico_campo SET campo='certidao_protocolo',tipo='text',nome='PROTOCOLO',valor='',largura='470',mascara='',site='0',ordenacao='14',obrigatorio='0'
						WHERE id_servico_campo='1525';
--18/05/2010 13:25:36
UPDATE vsites_servico_campo SET campo='certidao_finalidade',tipo='text',nome='FINALIDADE',valor='',largura='470',mascara='',site='1',ordenacao='15',obrigatorio='0'
						WHERE id_servico_campo='1526';
--18/05/2010 13:25:36
DELETE FROM vsites_servico_campo WHERE id_servico_campo = '' AND id_servico='177';
--18/05/2010 13:26:29
UPDATE vsites_servico SET dias='', status='Ativo', descricao='Histórico Escolar', site='1' WHERE id_servico='110';
--18/05/2010 13:26:29
UPDATE vsites_servico_campo SET campo='certidao_nome',tipo='text',nome='NOME',valor='',largura='470',mascara='',site='1',ordenacao='1',obrigatorio='1'
						WHERE id_servico_campo='771';
--18/05/2010 13:26:29
UPDATE vsites_servico_campo SET campo='certidao_mae',tipo='text',nome='MAE',valor='',largura='470',mascara='',site='1',ordenacao='2',obrigatorio='1'
						WHERE id_servico_campo='649';
--18/05/2010 13:26:29
UPDATE vsites_servico_campo SET campo='certidao_pai',tipo='text',nome='PAI',valor='',largura='470',mascara='',site='1',ordenacao='3',obrigatorio='0'
						WHERE id_servico_campo='915';
--18/05/2010 13:26:30
UPDATE vsites_servico_campo SET campo='certidao_data_nascimento',tipo='text',nome='DATA DE NASCIMENTO',valor='',largura='470',mascara='',site='1',ordenacao='4',obrigatorio='1'
						WHERE id_servico_campo='397';
--18/05/2010 13:26:30
UPDATE vsites_servico_campo SET campo='certidao_nome_escola',tipo='text',nome='NOME DA ESCOLA',valor='',largura='470',mascara='',site='1',ordenacao='5',obrigatorio='1'
						WHERE id_servico_campo='825';
--18/05/2010 13:26:30
UPDATE vsites_servico_campo SET campo='certidao_endereco',tipo='text',nome='ENDERECO',valor='',largura='470',mascara='',site='1',ordenacao='6',obrigatorio='0'
						WHERE id_servico_campo='437';
--18/05/2010 13:26:30
UPDATE vsites_servico_campo SET campo='certidao_cidade',tipo='text',nome='CIDADE',valor='',largura='470',mascara='',site='1',ordenacao='7',obrigatorio='1'
						WHERE id_servico_campo='1505';
--18/05/2010 13:26:30
UPDATE vsites_servico_campo SET campo='certidao_estado',tipo='text',nome='ESTADO',valor='',largura='470',mascara='',site='1',ordenacao='8',obrigatorio='1'
						WHERE id_servico_campo='1506';
--18/05/2010 13:26:30
UPDATE vsites_servico_campo SET campo='certidao_historico_ano',tipo='text',nome='ANO DE CONCLUSÃO',valor='',largura='470',mascara='',site='1',ordenacao='9',obrigatorio='1'
						WHERE id_servico_campo='1';
--18/05/2010 13:26:30
UPDATE vsites_servico_campo SET campo='certidao_serie',tipo='text',nome='SERIE',valor='',largura='470',mascara='',site='1',ordenacao='10',obrigatorio='1'
						WHERE id_servico_campo='1211';
--18/05/2010 13:26:30
DELETE FROM vsites_servico_campo WHERE id_servico_campo = '' AND id_servico='110';
--18/05/2010 13:26:49
UPDATE vsites_servico SET dias='', status='Ativo', descricao='Sinal Público', site='1' WHERE id_servico='62';
--18/05/2010 13:26:49
UPDATE vsites_servico_campo SET campo='certidao_nome',tipo='text',nome='NOME',valor='',largura='470',mascara='',site='1',ordenacao='1',obrigatorio='1'
						WHERE id_servico_campo='811';
--18/05/2010 13:26:50
UPDATE vsites_servico_campo SET campo='certidao_cidade',tipo='text',nome='CIDADE',valor='',largura='470',mascara='',site='1',ordenacao='2',obrigatorio='1'
						WHERE id_servico_campo='191';
--18/05/2010 13:26:50
UPDATE vsites_servico_campo SET campo='certidao_estado',tipo='text',nome='ESTADO',valor='',largura='470',mascara='',site='1',ordenacao='3',obrigatorio='1'
						WHERE id_servico_campo='555';
--18/05/2010 13:26:50
UPDATE vsites_servico_campo SET campo='certidao_cartorio',tipo='text',nome='CARTORIO',valor='',largura='470',mascara='',site='1',ordenacao='4',obrigatorio='1'
						WHERE id_servico_campo='75';
--18/05/2010 13:26:51
UPDATE vsites_servico_campo SET campo='certidao_nome_reconhecer',tipo='text',nome='NOME A RECONHECER',valor='',largura='470',mascara='',site='1',ordenacao='5',obrigatorio='1'
						WHERE id_servico_campo='824';
--18/05/2010 13:26:51
DELETE FROM vsites_servico_campo WHERE id_servico_campo = '' AND id_servico='62';
--18/05/2010 13:27:55
UPDATE vsites_servico SET dias='', status='Ativo', descricao='Averbação - Retificação', site='1' WHERE id_servico='54';
--18/05/2010 13:27:55
UPDATE vsites_servico_campo SET campo='certidao_nome',tipo='text',nome='NOME',valor='',largura='470',mascara='',site='1',ordenacao='1',obrigatorio='1'
						WHERE id_servico_campo='731';
--18/05/2010 13:27:56
UPDATE vsites_servico_campo SET campo='certidao_conjuge',tipo='text',nome='CONJUGE',valor='',largura='470',mascara='',site='1',ordenacao='2',obrigatorio='0'
						WHERE id_servico_campo='274';
--18/05/2010 13:27:56
UPDATE vsites_servico_campo SET campo='certidao_mae',tipo='text',nome='MAE',valor='',largura='470',mascara='',site='1',ordenacao='3',obrigatorio='0'
						WHERE id_servico_campo='640';
--18/05/2010 13:27:56
UPDATE vsites_servico_campo SET campo='certidao_pai',tipo='text',nome='PAI',valor='',largura='470',mascara='',site='1',ordenacao='4',obrigatorio='0'
						WHERE id_servico_campo='906';
--18/05/2010 13:27:57
UPDATE vsites_servico_campo SET campo='certidao_data_casamento',tipo='text',nome='DATA DE CASAMENTO',valor='',largura='470',mascara='',site='1',ordenacao='5',obrigatorio='0'
						WHERE id_servico_campo='363';
--18/05/2010 13:27:57
UPDATE vsites_servico_campo SET campo='certidao_data_nascimento',tipo='text',nome='DATA DE NASCIMENTO',valor='',largura='470',mascara='',site='1',ordenacao='6',obrigatorio='0'
						WHERE id_servico_campo='385';
--18/05/2010 13:27:57
UPDATE vsites_servico_campo SET campo='certidao_livro',tipo='text',nome='LIVRO',valor='',largura='470',mascara='',site='1',ordenacao='7',obrigatorio='0'
						WHERE id_servico_campo='618';
--18/05/2010 13:27:57
UPDATE vsites_servico_campo SET campo='certidao_folha',tipo='text',nome='FOLHA',valor='',largura='470',mascara='',site='1',ordenacao='8',obrigatorio='0'
						WHERE id_servico_campo='595';
--18/05/2010 13:27:57
UPDATE vsites_servico_campo SET campo='certidao_registro',tipo='text',nome='REGISTRO',valor='',largura='470',mascara='',site='1',ordenacao='9',obrigatorio='0'
						WHERE id_servico_campo='1043';
--18/05/2010 13:27:58
UPDATE vsites_servico_campo SET campo='certidao_data_registro',tipo='text',nome='DATA DO REGISTRO',valor='',largura='470',mascara='',site='1',ordenacao='10',obrigatorio='0'
						WHERE id_servico_campo='418';
--18/05/2010 13:27:58
UPDATE vsites_servico_campo SET campo='certidao_cidade',tipo='text',nome='CIDADE',valor='',largura='470',mascara='',site='1',ordenacao='11',obrigatorio='1'
						WHERE id_servico_campo='108';
--18/05/2010 13:27:58
UPDATE vsites_servico_campo SET campo='certidao_estado',tipo='text',nome='ESTADO',valor='',largura='470',mascara='',site='1',ordenacao='12',obrigatorio='1'
						WHERE id_servico_campo='474';
--18/05/2010 13:27:58
UPDATE vsites_servico_campo SET campo='certidao_cartorio',tipo='text',nome='CARTORIO',valor='',largura='470',mascara='',site='1',ordenacao='13',obrigatorio='0'
						WHERE id_servico_campo='27';
--18/05/2010 13:27:58
UPDATE vsites_servico_campo SET campo='certidao_averbacao',tipo='text',nome='AVERBACAO',valor='',largura='470',mascara='',site='1',ordenacao='14',obrigatorio='0'
						WHERE id_servico_campo='4';
--18/05/2010 13:27:59
UPDATE vsites_servico_campo SET campo='certidao_finalidade',tipo='text',nome='FINALIDADE DO DOCUMENTO',valor='',largura='470',mascara='',site='1',ordenacao='15',obrigatorio='0'
						WHERE id_servico_campo='576';
--18/05/2010 13:27:59
DELETE FROM vsites_servico_campo WHERE id_servico_campo = '' AND id_servico='54';
--18/05/2010 13:28:38
UPDATE vsites_servico SET dias='', status='Ativo', descricao='Averbação - Divórcio', site='1' WHERE id_servico='29';
--18/05/2010 13:28:38
UPDATE vsites_servico_campo SET campo='certidao_nome',tipo='text',nome='NOME',valor='',largura='470',mascara='',site='1',ordenacao='1',obrigatorio='1'
						WHERE id_servico_campo='730';
--18/05/2010 13:28:38
UPDATE vsites_servico_campo SET campo='certidao_conjuge',tipo='text',nome='CONJUGE',valor='',largura='470',mascara='',site='1',ordenacao='2',obrigatorio='1'
						WHERE id_servico_campo='273';
--18/05/2010 13:28:38
UPDATE vsites_servico_campo SET campo='certidao_data_casamento',tipo='text',nome='DATA DE CASAMENTO',valor='',largura='470',mascara='',site='1',ordenacao='3',obrigatorio='1'
						WHERE id_servico_campo='362';
--18/05/2010 13:28:38
UPDATE vsites_servico_campo SET campo='certidao_livro',tipo='text',nome='LIVRO',valor='',largura='470',mascara='',site='1',ordenacao='4',obrigatorio='0'
						WHERE id_servico_campo='617';
--18/05/2010 13:28:38
UPDATE vsites_servico_campo SET campo='certidao_folha',tipo='text',nome='FOLHA',valor='',largura='470',mascara='',site='1',ordenacao='5',obrigatorio='0'
						WHERE id_servico_campo='594';
--18/05/2010 13:28:38
UPDATE vsites_servico_campo SET campo='certidao_registro',tipo='text',nome='REGISTRO',valor='',largura='470',mascara='',site='1',ordenacao='6',obrigatorio='0'
						WHERE id_servico_campo='1042';
--18/05/2010 13:28:38
UPDATE vsites_servico_campo SET campo='certidao_cidade',tipo='text',nome='CIDADE',valor='',largura='470',mascara='',site='1',ordenacao='7',obrigatorio='1'
						WHERE id_servico_campo='107';
--18/05/2010 13:28:38
UPDATE vsites_servico_campo SET campo='certidao_estado',tipo='text',nome='ESTADO',valor='',largura='470',mascara='',site='1',ordenacao='8',obrigatorio='1'
						WHERE id_servico_campo='473';
--18/05/2010 13:28:39
UPDATE vsites_servico_campo SET campo='certidao_cartorio',tipo='text',nome='CARTORIO',valor='',largura='470',mascara='',site='1',ordenacao='9',obrigatorio='0'
						WHERE id_servico_campo='26';
--18/05/2010 13:28:39
UPDATE vsites_servico_campo SET campo='certidao_averbacao',tipo='text',nome='AVERBACAO',valor='',largura='470',mascara='',site='1',ordenacao='10',obrigatorio='0'
						WHERE id_servico_campo='3';
--18/05/2010 13:28:39
UPDATE vsites_servico_campo SET campo='certidao_finalidade',tipo='text',nome='FINALIDADE DO DOCUMENTO',valor='',largura='470',mascara='',site='1',ordenacao='11',obrigatorio='0'
						WHERE id_servico_campo='575';
--18/05/2010 13:28:39
DELETE FROM vsites_servico_campo WHERE id_servico_campo = '' AND id_servico='29';
--18/05/2010 13:32:26
UPDATE vsites_servico SET dias='', status='Ativo', descricao='Anotação - Óbito', site='1' WHERE id_servico='30';
--18/05/2010 13:32:26
UPDATE vsites_servico_campo SET campo='certidao_nome',tipo='text',nome='NOME',valor='',largura='470',mascara='',site='1',ordenacao='1',obrigatorio='1'
						WHERE id_servico_campo='728';
--18/05/2010 13:32:26
UPDATE vsites_servico_campo SET campo='certidao_conjuge',tipo='text',nome='CONJUGE',valor='',largura='470',mascara='',site='1',ordenacao='2',obrigatorio='0'
						WHERE id_servico_campo='272';
--18/05/2010 13:32:27
UPDATE vsites_servico_campo SET campo='certidao_pai',tipo='text',nome='PAI',valor='',largura='470',mascara='',site='1',ordenacao='3',obrigatorio='0'
						WHERE id_servico_campo='904';
--18/05/2010 13:32:27
UPDATE vsites_servico_campo SET campo='certidao_mae',tipo='text',nome='MAE',valor='',largura='470',mascara='',site='1',ordenacao='4',obrigatorio='0'
						WHERE id_servico_campo='638';
--18/05/2010 13:32:27
UPDATE vsites_servico_campo SET campo='certidao_data_casamento',tipo='text',nome='DATA DE CASAMENTO',valor='',largura='470',mascara='',site='1',ordenacao='5',obrigatorio='0'
						WHERE id_servico_campo='369';
--18/05/2010 13:32:28
UPDATE vsites_servico_campo SET campo='certidao_data_nascimento',tipo='text',nome='DATA DE NASCIMENTO',valor='',largura='470',mascara='',site='1',ordenacao='6',obrigatorio='0'
						WHERE id_servico_campo='1504';
--18/05/2010 13:32:28
UPDATE vsites_servico_campo SET campo='certidao_livro',tipo='text',nome='LIVRO',valor='',largura='470',mascara='',site='1',ordenacao='7',obrigatorio='0'
						WHERE id_servico_campo='616';
--18/05/2010 13:32:28
UPDATE vsites_servico_campo SET campo='certidao_folha',tipo='text',nome='FOLHA',valor='',largura='470',mascara='',site='1',ordenacao='8',obrigatorio='0'
						WHERE id_servico_campo='592';
--18/05/2010 13:32:28
UPDATE vsites_servico_campo SET campo='certidao_registro',tipo='text',nome='REGISTRO',valor='',largura='470',mascara='',site='1',ordenacao='9',obrigatorio='0'
						WHERE id_servico_campo='1041';
--18/05/2010 13:32:29
UPDATE vsites_servico_campo SET campo='certidao_cidade',tipo='text',nome='CIDADE',valor='',largura='470',mascara='',site='1',ordenacao='10',obrigatorio='1'
						WHERE id_servico_campo='105';
--18/05/2010 13:32:29
UPDATE vsites_servico_campo SET campo='certidao_estado',tipo='text',nome='ESTADO',valor='',largura='470',mascara='',site='1',ordenacao='11',obrigatorio='1'
						WHERE id_servico_campo='471';
--18/05/2010 13:32:29
UPDATE vsites_servico_campo SET campo='certidao_cartorio',tipo='text',nome='CARTÓRIO',valor='',largura='470',mascara='',site='1',ordenacao='12',obrigatorio='0'
						WHERE id_servico_campo='82';
--18/05/2010 13:32:29
UPDATE vsites_servico_campo SET campo='certidao_averbacao',tipo='text',nome='AVERBACAO',valor='',largura='470',mascara='',site='1',ordenacao='13',obrigatorio='0'
						WHERE id_servico_campo='2';
--18/05/2010 13:32:29
UPDATE vsites_servico_campo SET campo='certidao_finalidade',tipo='text',nome='FINALIDADE DO DOCUMENTO',valor='',largura='470',mascara='',site='1',ordenacao='14',obrigatorio='0'
						WHERE id_servico_campo='574';
--18/05/2010 13:32:29
DELETE FROM vsites_servico_campo WHERE id_servico_campo = '' AND id_servico='30';
--18/05/2010 13:33:38
UPDATE vsites_servico SET dias='', status='Ativo', descricao='Óbito', site='1' WHERE id_servico='4';
--18/05/2010 13:33:38
UPDATE vsites_servico_campo SET campo='certidao_nome',tipo='text',nome='NOME',valor='',largura='470',mascara='',site='1',ordenacao='1',obrigatorio='1'
						WHERE id_servico_campo='791';
--18/05/2010 13:33:38
UPDATE vsites_servico_campo SET campo='certidao_mae',tipo='text',nome='MAE',valor='',largura='470',mascara='',site='1',ordenacao='2',obrigatorio='0'
						WHERE id_servico_campo='657';
--18/05/2010 13:33:38
UPDATE vsites_servico_campo SET campo='certidao_pai',tipo='text',nome='PAI',valor='',largura='470',mascara='',site='1',ordenacao='3',obrigatorio='0'
						WHERE id_servico_campo='923';
--18/05/2010 13:33:38
UPDATE vsites_servico_campo SET campo='certidao_data_obito',tipo='text',nome='DATA DE OBITO',valor='',largura='470',mascara='',site='1',ordenacao='4',obrigatorio='1'
						WHERE id_servico_campo='413';
--18/05/2010 13:33:38
UPDATE vsites_servico_campo SET campo='certidao_livro',tipo='text',nome='LIVRO',valor='',largura='470',mascara='',site='1',ordenacao='5',obrigatorio='0'
						WHERE id_servico_campo='629';
--18/05/2010 13:33:39
UPDATE vsites_servico_campo SET campo='certidao_folha',tipo='text',nome='FOLHA',valor='',largura='470',mascara='',site='1',ordenacao='6',obrigatorio='0'
						WHERE id_servico_campo='607';
--18/05/2010 13:33:39
UPDATE vsites_servico_campo SET campo='certidao_termo',tipo='text',nome='TERMO',valor='',largura='470',mascara='',site='1',ordenacao='7',obrigatorio='0'
						WHERE id_servico_campo='1230';
--18/05/2010 13:33:39
UPDATE vsites_servico_campo SET campo='certidao_cidade',tipo='text',nome='CIDADE',valor='',largura='470',mascara='',site='1',ordenacao='8',obrigatorio='1'
						WHERE id_servico_campo='169';
--18/05/2010 13:33:39
UPDATE vsites_servico_campo SET campo='certidao_estado',tipo='text',nome='ESTADO',valor='',largura='470',mascara='',site='1',ordenacao='9',obrigatorio='1'
						WHERE id_servico_campo='533';
--18/05/2010 13:33:39
UPDATE vsites_servico_campo SET campo='certidao_cartorio',tipo='text',nome='CARTORIO',valor='',largura='470',mascara='',site='1',ordenacao='10',obrigatorio='0'
						WHERE id_servico_campo='59';
--18/05/2010 13:33:39
UPDATE vsites_servico_campo SET campo='certidao_cartorio_endereco',tipo='text',nome='ENDERECO DO CARTORIO',valor='',largura='470',mascara='',site='1',ordenacao='11',obrigatorio='0'
						WHERE id_servico_campo='460';
--18/05/2010 13:33:39
UPDATE vsites_servico_campo SET campo='certidao_registro',tipo='text',nome='REGISTRO',valor='',largura='470',mascara='',site='1',ordenacao='12',obrigatorio='0'
						WHERE id_servico_campo='1052';
--18/05/2010 13:33:39
UPDATE vsites_servico_campo SET campo='certidao_data_registro',tipo='text',nome='DATA DO REGISTRO',valor='',largura='470',mascara='',site='1',ordenacao='13',obrigatorio='0'
						WHERE id_servico_campo='425';
--18/05/2010 13:33:39
UPDATE vsites_servico_campo SET campo='certidao_protocolo',tipo='text',nome='PROTOCOLO',valor='',largura='470',mascara='',site='0',ordenacao='14',obrigatorio='0'
						WHERE id_servico_campo='1007';
--18/05/2010 13:33:39
UPDATE vsites_servico_campo SET campo='certidao_finalidade',tipo='text',nome='FINALIDADE DO DOCUMENTO',valor='',largura='470',mascara='',site='1',ordenacao='15',obrigatorio='0'
						WHERE id_servico_campo='586';
--18/05/2010 13:33:39
UPDATE vsites_servico_campo SET campo='certidao_averbacao',tipo='text',nome='AVERBACAO',valor='',largura='470',mascara='',site='1',ordenacao='16',obrigatorio='0'
						WHERE id_servico_campo='13';
--18/05/2010 13:33:39
DELETE FROM vsites_servico_campo WHERE id_servico_campo = '' AND id_servico='4';
--18/05/2010 13:34:07
UPDATE vsites_servico SET dias='', status='Ativo', descricao='Casamento', site='1' WHERE id_servico='3';
--18/05/2010 13:34:07
UPDATE vsites_servico_campo SET campo='certidao_nome',tipo='text',nome='NOME',valor='',largura='470',mascara='',site='1',ordenacao='1',obrigatorio='1'
						WHERE id_servico_campo='745';
--18/05/2010 13:34:08
UPDATE vsites_servico_campo SET campo='certidao_esposa',tipo='text',nome='ESPOSA/ESPOSO',valor='',largura='470',mascara='',site='1',ordenacao='2',obrigatorio='1'
						WHERE id_servico_campo='464';
--18/05/2010 13:34:08
UPDATE vsites_servico_campo SET campo='certidao_data_casamento',tipo='text',nome='DATA DE CASAMENTO',valor='',largura='470',mascara='',site='1',ordenacao='3',obrigatorio='1'
						WHERE id_servico_campo='364';
--18/05/2010 13:34:08
UPDATE vsites_servico_campo SET campo='certidao_livro',tipo='text',nome='LIVRO',valor='',largura='470',mascara='',site='1',ordenacao='4',obrigatorio='0'
						WHERE id_servico_campo='619';
--18/05/2010 13:34:08
UPDATE vsites_servico_campo SET campo='certidao_folha',tipo='text',nome='FOLHA',valor='',largura='470',mascara='',site='1',ordenacao='5',obrigatorio='0'
						WHERE id_servico_campo='596';
--18/05/2010 13:34:08
UPDATE vsites_servico_campo SET campo='certidao_registro',tipo='text',nome='REGISTRO',valor='',largura='470',mascara='',site='1',ordenacao='6',obrigatorio='0'
						WHERE id_servico_campo='1044';
--18/05/2010 13:34:08
UPDATE vsites_servico_campo SET campo='certidao_cidade',tipo='text',nome='CIDADE',valor='',largura='470',mascara='',site='1',ordenacao='7',obrigatorio='1'
						WHERE id_servico_campo='122';
--18/05/2010 13:34:08
UPDATE vsites_servico_campo SET campo='certidao_estado',tipo='text',nome='ESTADO',valor='',largura='470',mascara='',site='1',ordenacao='8',obrigatorio='1'
						WHERE id_servico_campo='488';
--18/05/2010 13:34:08
UPDATE vsites_servico_campo SET campo='certidao_averbacao',tipo='text',nome='AVERBACAO',valor='',largura='470',mascara='',site='1',ordenacao='9',obrigatorio='0'
						WHERE id_servico_campo='5';
--18/05/2010 13:34:08
UPDATE vsites_servico_campo SET campo='certidao_cartorio',tipo='text',nome='CARTORIO',valor='',largura='470',mascara='',site='1',ordenacao='10',obrigatorio='0'
						WHERE id_servico_campo='34';
--18/05/2010 13:34:09
UPDATE vsites_servico_campo SET campo='certidao_finalidade',tipo='text',nome='FINALIDADE DO DOCUMENTO',valor='',largura='470',mascara='',site='1',ordenacao='11',obrigatorio='0'
						WHERE id_servico_campo='578';
--18/05/2010 13:34:09
DELETE FROM vsites_servico_campo WHERE id_servico_campo = '' AND id_servico='3';
--18/05/2010 13:34:40
UPDATE vsites_servico SET dias='', status='Ativo', descricao='Batismo', site='1' WHERE id_servico='83';
--18/05/2010 13:34:40
UPDATE vsites_servico_campo SET campo='certidao_nome',tipo='text',nome='NOME',valor='',largura='470',mascara='',site='1',ordenacao='1',obrigatorio='1'
						WHERE id_servico_campo='735';
--18/05/2010 13:34:40
UPDATE vsites_servico_campo SET campo='certidao_mae',tipo='text',nome='MAE',valor='',largura='470',mascara='',site='1',ordenacao='2',obrigatorio='1'
						WHERE id_servico_campo='641';
--18/05/2010 13:34:40
UPDATE vsites_servico_campo SET campo='certidao_pai',tipo='text',nome='PAI',valor='',largura='470',mascara='',site='1',ordenacao='3',obrigatorio='0'
						WHERE id_servico_campo='907';
--18/05/2010 13:34:40
UPDATE vsites_servico_campo SET campo='certidao_data_batismo',tipo='text',nome='DATA DO BATISMO',valor='',largura='470',mascara='',site='1',ordenacao='4',obrigatorio='1'
						WHERE id_servico_campo='416';
--18/05/2010 13:34:40
UPDATE vsites_servico_campo SET campo='certidao_igreja',tipo='text',nome='IGREJA',valor='',largura='470',mascara='',site='1',ordenacao='5',obrigatorio='1'
						WHERE id_servico_campo='1544';
--18/05/2010 13:34:40
UPDATE vsites_servico_campo SET campo='certidao_cidade',tipo='text',nome='CIDADE',valor='',largura='470',mascara='',site='1',ordenacao='6',obrigatorio='1'
						WHERE id_servico_campo='113';
--18/05/2010 13:34:40
UPDATE vsites_servico_campo SET campo='certidao_estado',tipo='text',nome='ESTADO',valor='',largura='470',mascara='',site='1',ordenacao='7',obrigatorio='1'
						WHERE id_servico_campo='479';
--18/05/2010 13:34:41
UPDATE vsites_servico_campo SET campo='certidao_padre',tipo='text',nome='PADRE',valor='',largura='470',mascara='',site='1',ordenacao='8',obrigatorio='0'
						WHERE id_servico_campo='903';
--18/05/2010 13:34:41
DELETE FROM vsites_servico_campo WHERE id_servico_campo = '' AND id_servico='83';
--18/05/2010 13:35:15
UPDATE vsites_servico SET dias='', status='Ativo', descricao='Nascimento', site='1' WHERE id_servico='2';
--18/05/2010 13:35:15
UPDATE vsites_servico_campo SET campo='certidao_nome',tipo='text',nome='NOME',valor='',largura='470',mascara='',site='1',ordenacao='1',obrigatorio='1'
						WHERE id_servico_campo='785';
--18/05/2010 13:35:15
UPDATE vsites_servico_campo SET campo='certidao_pai',tipo='text',nome='PAI',valor='',largura='470',mascara='',site='1',ordenacao='2',obrigatorio='0'
						WHERE id_servico_campo='921';
--18/05/2010 13:35:15
UPDATE vsites_servico_campo SET campo='certidao_mae',tipo='text',nome='MAE',valor='',largura='470',mascara='',site='1',ordenacao='3',obrigatorio='1'
						WHERE id_servico_campo='655';
--18/05/2010 13:35:15
UPDATE vsites_servico_campo SET campo='certidao_data_nascimento',tipo='text',nome='DATA DE NASCIMENTO',valor='',largura='470',mascara='',site='1',ordenacao='4',obrigatorio='1'
						WHERE id_servico_campo='404';
--18/05/2010 13:35:15
UPDATE vsites_servico_campo SET campo='certidao_livro',tipo='text',nome='LIVRO',valor='',largura='470',mascara='',site='1',ordenacao='5',obrigatorio='0'
						WHERE id_servico_campo='627';
--18/05/2010 13:35:15
UPDATE vsites_servico_campo SET campo='certidao_folha',tipo='text',nome='FOLHA',valor='',largura='470',mascara='',site='1',ordenacao='6',obrigatorio='0'
						WHERE id_servico_campo='605';
--18/05/2010 13:35:15
UPDATE vsites_servico_campo SET campo='certidao_registro',tipo='text',nome='REGISTRO',valor='',largura='470',mascara='',site='1',ordenacao='7',obrigatorio='0'
						WHERE id_servico_campo='1050';
--18/05/2010 13:35:15
UPDATE vsites_servico_campo SET campo='certidao_cidade',tipo='text',nome='CIDADE',valor='',largura='470',mascara='',site='1',ordenacao='8',obrigatorio='1'
						WHERE id_servico_campo='163';
--18/05/2010 13:35:15
UPDATE vsites_servico_campo SET campo='certidao_estado',tipo='text',nome='ESTADO',valor='',largura='470',mascara='',site='1',ordenacao='9',obrigatorio='1'
						WHERE id_servico_campo='527';
--18/05/2010 13:35:15
UPDATE vsites_servico_campo SET campo='certidao_cartorio',tipo='text',nome='CARTORIO',valor='',largura='470',mascara='',site='1',ordenacao='10',obrigatorio='0'
						WHERE id_servico_campo='54';
--18/05/2010 13:35:15
UPDATE vsites_servico_campo SET campo='certidao_cartorio_cep',tipo='text',nome='CEP DO CARTORIO',valor='',largura='470',mascara='',site='1',ordenacao='11',obrigatorio='0'
						WHERE id_servico_campo='98';
--18/05/2010 13:35:15
UPDATE vsites_servico_campo SET campo='certidao_data_registro',tipo='text',nome='DATA DO REGISTRO',valor='',largura='470',mascara='',site='1',ordenacao='12',obrigatorio='0'
						WHERE id_servico_campo='423';
--18/05/2010 13:35:15
UPDATE vsites_servico_campo SET campo='certidao_protocolo',tipo='text',nome='PROTOCOLO',valor='',largura='470',mascara='',site='0',ordenacao='13',obrigatorio='0'
						WHERE id_servico_campo='1001';
--18/05/2010 13:35:15
UPDATE vsites_servico_campo SET campo='certidao_averbacao',tipo='text',nome='AVERBACAO',valor='',largura='470',mascara='',site='1',ordenacao='14',obrigatorio='0'
						WHERE id_servico_campo='11';
--18/05/2010 13:35:16
UPDATE vsites_servico_campo SET campo='certidao_finalidade',tipo='text',nome='FINALIDADE DO DOCUMENTO',valor='',largura='470',mascara='',site='1',ordenacao='15',obrigatorio='0'
						WHERE id_servico_campo='584';
--18/05/2010 13:35:16
UPDATE vsites_servico_campo SET campo='certidao_tem_copia_doc',tipo='text',nome='TEM COPIA DO DOCUMENTO',valor='',largura='470',mascara='',site='1',ordenacao='16',obrigatorio='0'
						WHERE id_servico_campo='1228';
--18/05/2010 13:35:16
DELETE FROM vsites_servico_campo WHERE id_servico_campo = '' AND id_servico='2';
--18/05/2010 13:35:46
UPDATE vsites_servico SET dias='', status='Ativo', descricao='Inteiro Teor - Casamento', site='1' WHERE id_servico='10';
--18/05/2010 13:35:46
UPDATE vsites_servico_campo SET campo='certidao_nome',tipo='text',nome='NOME',valor='',largura='470',mascara='',site='1',ordenacao='1',obrigatorio='1'
						WHERE id_servico_campo='772';
--18/05/2010 13:35:46
UPDATE vsites_servico_campo SET campo='certidao_esposa',tipo='text',nome='ESPOSA/ESPOSO',valor='',largura='470',mascara='',site='1',ordenacao='2',obrigatorio='1'
						WHERE id_servico_campo='465';
--18/05/2010 13:35:46
UPDATE vsites_servico_campo SET campo='certidao_data_casamento',tipo='text',nome='DATA DE CASAMENTO',valor='',largura='470',mascara='',site='1',ordenacao='3',obrigatorio='1'
						WHERE id_servico_campo='365';
--18/05/2010 13:35:46
UPDATE vsites_servico_campo SET campo='certidao_livro',tipo='text',nome='LIVRO',valor='',largura='470',mascara='',site='1',ordenacao='4',obrigatorio='0'
						WHERE id_servico_campo='624';
--18/05/2010 13:35:46
UPDATE vsites_servico_campo SET campo='certidao_folha',tipo='text',nome='FOLHA',valor='',largura='470',mascara='',site='1',ordenacao='5',obrigatorio='0'
						WHERE id_servico_campo='602';
--18/05/2010 13:35:46
UPDATE vsites_servico_campo SET campo='certidao_registro',tipo='text',nome='REGISTRO',valor='',largura='470',mascara='',site='1',ordenacao='6',obrigatorio='0'
						WHERE id_servico_campo='1047';
--18/05/2010 13:35:46
UPDATE vsites_servico_campo SET campo='certidao_cidade',tipo='text',nome='CIDADE',valor='',largura='470',mascara='',site='1',ordenacao='7',obrigatorio='1'
						WHERE id_servico_campo='148';
--18/05/2010 13:35:46
UPDATE vsites_servico_campo SET campo='certidao_estado',tipo='text',nome='ESTADO',valor='',largura='470',mascara='',site='1',ordenacao='8',obrigatorio='1'
						WHERE id_servico_campo='512';
--18/05/2010 13:35:46
UPDATE vsites_servico_campo SET campo='certidao_averbacao',tipo='text',nome='AVERBACAO',valor='',largura='470',mascara='',site='1',ordenacao='9',obrigatorio='0'
						WHERE id_servico_campo='8';
--18/05/2010 13:35:46
UPDATE vsites_servico_campo SET campo='certidao_cartorio',tipo='text',nome='CARTORIO',valor='',largura='470',mascara='',site='1',ordenacao='10',obrigatorio='0'
						WHERE id_servico_campo='47';
--18/05/2010 13:35:46
UPDATE vsites_servico_campo SET campo='certidao_finalidade',tipo='text',nome='FINALIDADE DO DOCUMENTO',valor='',largura='470',mascara='',site='1',ordenacao='11',obrigatorio='0'
						WHERE id_servico_campo='581';
--18/05/2010 13:35:46
DELETE FROM vsites_servico_campo WHERE id_servico_campo = '' AND id_servico='10';
--18/05/2010 13:36:22
UPDATE vsites_servico SET dias='', status='Ativo', descricao='Inteiro Teor - Nascimento', site='1' WHERE id_servico='178';
--18/05/2010 13:36:22
UPDATE vsites_servico_campo SET campo='certidao_nome',tipo='text',nome='NOME',valor='',largura='470',mascara='',site='1',ordenacao='1',obrigatorio='1'
						WHERE id_servico_campo='1527';
--18/05/2010 13:36:22
UPDATE vsites_servico_campo SET campo='certidao_mae',tipo='text',nome='MÃE',valor='',largura='470',mascara='',site='1',ordenacao='2',obrigatorio='1'
						WHERE id_servico_campo='1531';
--18/05/2010 13:36:22
UPDATE vsites_servico_campo SET campo='certidao_pai',tipo='text',nome='PAI',valor='',largura='470',mascara='',site='1',ordenacao='3',obrigatorio='0'
						WHERE id_servico_campo='1532';
--18/05/2010 13:36:22
UPDATE vsites_servico_campo SET campo='certidao_data_nascimento',tipo='text',nome='DATA DE NASCIMENTO',valor='',largura='470',mascara='',site='1',ordenacao='4',obrigatorio='1'
						WHERE id_servico_campo='1528';
--18/05/2010 13:36:22
UPDATE vsites_servico_campo SET campo='certidao_livro',tipo='text',nome='LIVRO',valor='',largura='470',mascara='',site='1',ordenacao='5',obrigatorio='0'
						WHERE id_servico_campo='1533';
--18/05/2010 13:36:22
UPDATE vsites_servico_campo SET campo='certidao_folha',tipo='text',nome='FOLHA',valor='',largura='470',mascara='',site='1',ordenacao='6',obrigatorio='0'
						WHERE id_servico_campo='1534';
--18/05/2010 13:36:22
UPDATE vsites_servico_campo SET campo='certidao_registro',tipo='text',nome='REGISTRO',valor='',largura='470',mascara='',site='1',ordenacao='7',obrigatorio='0'
						WHERE id_servico_campo='1538';
--18/05/2010 13:36:22
UPDATE vsites_servico_campo SET campo='certidao_cidade',tipo='text',nome='CIDADE',valor='',largura='470',mascara='',site='1',ordenacao='8',obrigatorio='1'
						WHERE id_servico_campo='1529';
--18/05/2010 13:36:22
UPDATE vsites_servico_campo SET campo='certidao_estado',tipo='text',nome='ESTADO',valor='',largura='470',mascara='',site='1',ordenacao='9',obrigatorio='1'
						WHERE id_servico_campo='1530';
--18/05/2010 13:36:22
UPDATE vsites_servico_campo SET campo='certidao_cartorio',tipo='text',nome='CARTÓRIO',valor='',largura='470',mascara='',site='1',ordenacao='10',obrigatorio='0'
						WHERE id_servico_campo='1536';
--18/05/2010 13:36:22
UPDATE vsites_servico_campo SET campo='certidao_cartorio_cep',tipo='text',nome='CEP DO CARTÓRIO',valor='',largura='470',mascara='',site='1',ordenacao='11',obrigatorio='0'
						WHERE id_servico_campo='1537';
--18/05/2010 13:36:22
UPDATE vsites_servico_campo SET campo='certidao_data_registro',tipo='text',nome='DATA DO REGISTRO',valor='',largura='470',mascara='',site='1',ordenacao='12',obrigatorio='0'
						WHERE id_servico_campo='1539';
--18/05/2010 13:36:22
UPDATE vsites_servico_campo SET campo='certidao_protocolo',tipo='text',nome='PROTOCOLO',valor='',largura='470',mascara='',site='0',ordenacao='13',obrigatorio='0'
						WHERE id_servico_campo='1535';
--18/05/2010 13:36:22
UPDATE vsites_servico_campo SET campo='certidao_averbacao',tipo='text',nome='AVERBAÇÃO',valor='',largura='470',mascara='',site='1',ordenacao='14',obrigatorio='0'
						WHERE id_servico_campo='1540';
--18/05/2010 13:36:22
UPDATE vsites_servico_campo SET campo='certidao_finalidade',tipo='text',nome='FINALIDADE',valor='',largura='470',mascara='',site='1',ordenacao='15',obrigatorio='0'
						WHERE id_servico_campo='1541';
--18/05/2010 13:36:22
UPDATE vsites_servico_campo SET campo='certidao_tem_copia_doc',tipo='text',nome='TEM CÓPIA DO DOC',valor='',largura='470',mascara='',site='1',ordenacao='16',obrigatorio='0'
						WHERE id_servico_campo='1542';
--18/05/2010 13:36:22
DELETE FROM vsites_servico_campo WHERE id_servico_campo = '' AND id_servico='178';
--18/05/2010 13:36:49
UPDATE vsites_servico SET dias='', status='Ativo', descricao='Inteiro Teor - Óbito', site='1' WHERE id_servico='177';
--18/05/2010 13:36:49
UPDATE vsites_servico_campo SET campo='certidao_nome',tipo='text',nome='NOME',valor='',largura='470',mascara='',site='1',ordenacao='1',obrigatorio='1'
						WHERE id_servico_campo='1512';
--18/05/2010 13:36:49
UPDATE vsites_servico_campo SET campo='certidao_mae',tipo='text',nome='MÃE',valor='',largura='470',mascara='',site='1',ordenacao='2',obrigatorio='0'
						WHERE id_servico_campo='1515';
--18/05/2010 13:36:49
UPDATE vsites_servico_campo SET campo='certidao_pai',tipo='text',nome='PAI',valor='',largura='470',mascara='',site='1',ordenacao='3',obrigatorio='0'
						WHERE id_servico_campo='1516';
--18/05/2010 13:36:50
UPDATE vsites_servico_campo SET campo='certidao_data_obito',tipo='text',nome='DATA DE ÓBITO',valor='',largura='470',mascara='',site='1',ordenacao='4',obrigatorio='1'
						WHERE id_servico_campo='1517';
--18/05/2010 13:36:50
UPDATE vsites_servico_campo SET campo='certidao_livro',tipo='text',nome='LIVRO',valor='',largura='470',mascara='',site='1',ordenacao='5',obrigatorio='0'
						WHERE id_servico_campo='1518';
--18/05/2010 13:36:50
UPDATE vsites_servico_campo SET campo='certidao_folha',tipo='text',nome='FOLHA',valor='',largura='470',mascara='',site='1',ordenacao='6',obrigatorio='0'
						WHERE id_servico_campo='1519';
--18/05/2010 13:36:50
UPDATE vsites_servico_campo SET campo='certidao_termo',tipo='text',nome='TERMO',valor='',largura='470',mascara='',site='1',ordenacao='7',obrigatorio='0'
						WHERE id_servico_campo='1520';
--18/05/2010 13:36:50
UPDATE vsites_servico_campo SET campo='certidao_cidade',tipo='text',nome='CIDADE',valor='',largura='470',mascara='',site='1',ordenacao='8',obrigatorio='1'
						WHERE id_servico_campo='1513';
--18/05/2010 13:36:50
UPDATE vsites_servico_campo SET campo='certidao_estado',tipo='text',nome='ESTADO',valor='',largura='470',mascara='',site='1',ordenacao='9',obrigatorio='1'
						WHERE id_servico_campo='1514';
--18/05/2010 13:36:50
UPDATE vsites_servico_campo SET campo='certidao_cartorio',tipo='text',nome='CARTÓRIO',valor='',largura='470',mascara='',site='1',ordenacao='10',obrigatorio='0'
						WHERE id_servico_campo='1521';
--18/05/2010 13:36:50
UPDATE vsites_servico_campo SET campo='certidao_cartorio_endereco',tipo='text',nome='ENDEREÇO CARTÓRIO',valor='',largura='470',mascara='',site='1',ordenacao='11',obrigatorio='0'
						WHERE id_servico_campo='1522';
--18/05/2010 13:36:50
UPDATE vsites_servico_campo SET campo='certidao_registro',tipo='text',nome='REGISTRO',valor='',largura='470',mascara='',site='1',ordenacao='12',obrigatorio='0'
						WHERE id_servico_campo='1523';
--18/05/2010 13:36:50
UPDATE vsites_servico_campo SET campo='certidao_data_registro',tipo='text',nome='DATA DO REGISTRO',valor='',largura='470',mascara='',site='1',ordenacao='13',obrigatorio='0'
						WHERE id_servico_campo='1524';
--18/05/2010 13:36:50
UPDATE vsites_servico_campo SET campo='certidao_protocolo',tipo='text',nome='PROTOCOLO',valor='',largura='470',mascara='',site='0',ordenacao='14',obrigatorio='0'
						WHERE id_servico_campo='1525';
--18/05/2010 13:36:50
UPDATE vsites_servico_campo SET campo='certidao_finalidade',tipo='text',nome='FINALIDADE',valor='',largura='470',mascara='',site='1',ordenacao='15',obrigatorio='0'
						WHERE id_servico_campo='1526';
--18/05/2010 13:36:50
DELETE FROM vsites_servico_campo WHERE id_servico_campo = '' AND id_servico='177';
--18/05/2010 13:37:09
UPDATE vsites_servico SET dias='', status='Ativo', descricao='Histórico Escolar', site='1' WHERE id_servico='110';
--18/05/2010 13:37:09
UPDATE vsites_servico_campo SET campo='certidao_nome',tipo='text',nome='NOME',valor='',largura='470',mascara='',site='1',ordenacao='1',obrigatorio='1'
						WHERE id_servico_campo='771';
--18/05/2010 13:37:09
UPDATE vsites_servico_campo SET campo='certidao_mae',tipo='text',nome='MAE',valor='',largura='470',mascara='',site='1',ordenacao='2',obrigatorio='1'
						WHERE id_servico_campo='649';
--18/05/2010 13:37:09
UPDATE vsites_servico_campo SET campo='certidao_pai',tipo='text',nome='PAI',valor='',largura='470',mascara='',site='1',ordenacao='3',obrigatorio='0'
						WHERE id_servico_campo='915';
--18/05/2010 13:37:09
UPDATE vsites_servico_campo SET campo='certidao_data_nascimento',tipo='text',nome='DATA DE NASCIMENTO',valor='',largura='470',mascara='',site='1',ordenacao='4',obrigatorio='1'
						WHERE id_servico_campo='397';
--18/05/2010 13:37:09
UPDATE vsites_servico_campo SET campo='certidao_nome_escola',tipo='text',nome='NOME DA ESCOLA',valor='',largura='470',mascara='',site='1',ordenacao='5',obrigatorio='1'
						WHERE id_servico_campo='825';
--18/05/2010 13:37:10
UPDATE vsites_servico_campo SET campo='certidao_endereco',tipo='text',nome='ENDERECO',valor='',largura='470',mascara='',site='1',ordenacao='6',obrigatorio='0'
						WHERE id_servico_campo='437';
--18/05/2010 13:37:10
UPDATE vsites_servico_campo SET campo='certidao_cidade',tipo='text',nome='CIDADE',valor='',largura='470',mascara='',site='1',ordenacao='7',obrigatorio='1'
						WHERE id_servico_campo='1505';
--18/05/2010 13:37:10
UPDATE vsites_servico_campo SET campo='certidao_estado',tipo='text',nome='ESTADO',valor='',largura='470',mascara='',site='1',ordenacao='8',obrigatorio='1'
						WHERE id_servico_campo='1506';
--18/05/2010 13:37:10
UPDATE vsites_servico_campo SET campo='certidao_historico_ano',tipo='text',nome='ANO DE CONCLUSÃO',valor='',largura='470',mascara='',site='1',ordenacao='9',obrigatorio='1'
						WHERE id_servico_campo='1';
--18/05/2010 13:37:10
UPDATE vsites_servico_campo SET campo='certidao_serie',tipo='text',nome='SERIE',valor='',largura='470',mascara='',site='1',ordenacao='10',obrigatorio='1'
						WHERE id_servico_campo='1211';
--18/05/2010 13:37:10
DELETE FROM vsites_servico_campo WHERE id_servico_campo = '' AND id_servico='110';
--18/05/2010 13:39:35
UPDATE vsites_servico SET dias='', status='Ativo', descricao='Averbação - Retificação', site='1' WHERE id_servico='54';
--18/05/2010 13:39:35
UPDATE vsites_servico_campo SET campo='certidao_nome',tipo='text',nome='NOME',valor='',largura='470',mascara='',site='1',ordenacao='1',obrigatorio='1'
						WHERE id_servico_campo='731';
--18/05/2010 13:39:35
UPDATE vsites_servico_campo SET campo='certidao_conjuge',tipo='text',nome='CONJUGE',valor='',largura='470',mascara='',site='1',ordenacao='2',obrigatorio='0'
						WHERE id_servico_campo='274';
--18/05/2010 13:39:35
UPDATE vsites_servico_campo SET campo='certidao_mae',tipo='text',nome='MAE',valor='',largura='470',mascara='',site='1',ordenacao='3',obrigatorio='0'
						WHERE id_servico_campo='640';
--18/05/2010 13:39:35
UPDATE vsites_servico_campo SET campo='certidao_pai',tipo='text',nome='PAI',valor='',largura='470',mascara='',site='1',ordenacao='4',obrigatorio='0'
						WHERE id_servico_campo='906';
--18/05/2010 13:39:35
UPDATE vsites_servico_campo SET campo='certidao_data_casamento',tipo='text',nome='DATA DE CASAMENTO',valor='',largura='470',mascara='',site='1',ordenacao='5',obrigatorio='0'
						WHERE id_servico_campo='363';
--18/05/2010 13:39:35
UPDATE vsites_servico_campo SET campo='certidao_data_nascimento',tipo='text',nome='DATA DE NASCIMENTO',valor='',largura='470',mascara='',site='1',ordenacao='6',obrigatorio='0'
						WHERE id_servico_campo='385';
--18/05/2010 13:39:35
UPDATE vsites_servico_campo SET campo='certidao_livro',tipo='text',nome='LIVRO',valor='',largura='470',mascara='',site='1',ordenacao='7',obrigatorio='0'
						WHERE id_servico_campo='618';
--18/05/2010 13:39:35
UPDATE vsites_servico_campo SET campo='certidao_folha',tipo='text',nome='FOLHA',valor='',largura='470',mascara='',site='1',ordenacao='8',obrigatorio='0'
						WHERE id_servico_campo='595';
--18/05/2010 13:39:35
UPDATE vsites_servico_campo SET campo='certidao_registro',tipo='text',nome='REGISTRO',valor='',largura='470',mascara='',site='1',ordenacao='9',obrigatorio='0'
						WHERE id_servico_campo='1043';
--18/05/2010 13:39:35
UPDATE vsites_servico_campo SET campo='certidao_data_registro',tipo='text',nome='DATA DO REGISTRO',valor='',largura='470',mascara='',site='1',ordenacao='10',obrigatorio='0'
						WHERE id_servico_campo='418';
--18/05/2010 13:39:35
UPDATE vsites_servico_campo SET campo='certidao_cidade',tipo='text',nome='CIDADE',valor='',largura='470',mascara='',site='1',ordenacao='11',obrigatorio='1'
						WHERE id_servico_campo='108';
--18/05/2010 13:39:35
UPDATE vsites_servico_campo SET campo='certidao_estado',tipo='text',nome='ESTADO',valor='',largura='470',mascara='',site='1',ordenacao='12',obrigatorio='1'
						WHERE id_servico_campo='474';
--18/05/2010 13:39:35
UPDATE vsites_servico_campo SET campo='certidao_cartorio',tipo='text',nome='CARTORIO',valor='',largura='470',mascara='',site='1',ordenacao='13',obrigatorio='0'
						WHERE id_servico_campo='27';
--18/05/2010 13:39:35
UPDATE vsites_servico_campo SET campo='certidao_averbacao',tipo='text',nome='AVERBACAO',valor='',largura='470',mascara='',site='1',ordenacao='14',obrigatorio='0'
						WHERE id_servico_campo='4';
--18/05/2010 13:39:36
UPDATE vsites_servico_campo SET campo='certidao_finalidade',tipo='text',nome='FINALIDADE DO DOCUMENTO',valor='',largura='470',mascara='',site='1',ordenacao='15',obrigatorio='0'
						WHERE id_servico_campo='576';
--18/05/2010 13:39:36
DELETE FROM vsites_servico_campo WHERE id_servico_campo = '' AND id_servico='54';
--18/05/2010 13:40:12
UPDATE vsites_servico SET dias='', status='Ativo', descricao='Averbação - Divórcio', site='1' WHERE id_servico='29';
--18/05/2010 13:40:12
UPDATE vsites_servico_campo SET campo='certidao_nome',tipo='text',nome='NOME',valor='',largura='470',mascara='',site='1',ordenacao='1',obrigatorio='1'
						WHERE id_servico_campo='730';
--18/05/2010 13:40:12
UPDATE vsites_servico_campo SET campo='certidao_conjuge',tipo='text',nome='CONJUGE',valor='',largura='470',mascara='',site='1',ordenacao='2',obrigatorio='1'
						WHERE id_servico_campo='273';
--18/05/2010 13:40:12
UPDATE vsites_servico_campo SET campo='certidao_data_casamento',tipo='text',nome='DATA DE CASAMENTO',valor='',largura='470',mascara='',site='1',ordenacao='3',obrigatorio='1'
						WHERE id_servico_campo='362';
--18/05/2010 13:40:12
UPDATE vsites_servico_campo SET campo='certidao_livro',tipo='text',nome='LIVRO',valor='',largura='470',mascara='',site='1',ordenacao='4',obrigatorio='0'
						WHERE id_servico_campo='617';
--18/05/2010 13:40:12
UPDATE vsites_servico_campo SET campo='certidao_folha',tipo='text',nome='FOLHA',valor='',largura='470',mascara='',site='1',ordenacao='5',obrigatorio='0'
						WHERE id_servico_campo='594';
--18/05/2010 13:40:12
UPDATE vsites_servico_campo SET campo='certidao_registro',tipo='text',nome='REGISTRO',valor='',largura='470',mascara='',site='1',ordenacao='6',obrigatorio='0'
						WHERE id_servico_campo='1042';
--18/05/2010 13:40:13
UPDATE vsites_servico_campo SET campo='certidao_cidade',tipo='text',nome='CIDADE',valor='',largura='470',mascara='',site='1',ordenacao='7',obrigatorio='1'
						WHERE id_servico_campo='107';
--18/05/2010 13:40:13
UPDATE vsites_servico_campo SET campo='certidao_estado',tipo='text',nome='ESTADO',valor='',largura='470',mascara='',site='1',ordenacao='8',obrigatorio='1'
						WHERE id_servico_campo='473';
--18/05/2010 13:40:13
UPDATE vsites_servico_campo SET campo='certidao_cartorio',tipo='text',nome='CARTORIO',valor='',largura='470',mascara='',site='1',ordenacao='9',obrigatorio='0'
						WHERE id_servico_campo='26';
--18/05/2010 13:40:13
UPDATE vsites_servico_campo SET campo='certidao_averbacao',tipo='text',nome='AVERBACAO',valor='',largura='470',mascara='',site='1',ordenacao='10',obrigatorio='0'
						WHERE id_servico_campo='3';
--18/05/2010 13:40:13
UPDATE vsites_servico_campo SET campo='certidao_finalidade',tipo='text',nome='FINALIDADE DO DOCUMENTO',valor='',largura='470',mascara='',site='1',ordenacao='11',obrigatorio='0'
						WHERE id_servico_campo='575';
--18/05/2010 13:40:13
DELETE FROM vsites_servico_campo WHERE id_servico_campo = '' AND id_servico='29';
--18/05/2010 13:40:55
UPDATE vsites_servico SET dias='', status='Ativo', descricao='Anotação - Óbito', site='1' WHERE id_servico='30';
--18/05/2010 13:40:55
UPDATE vsites_servico_campo SET campo='certidao_nome',tipo='text',nome='NOME',valor='',largura='470',mascara='',site='1',ordenacao='1',obrigatorio='1'
						WHERE id_servico_campo='728';
--18/05/2010 13:40:55
UPDATE vsites_servico_campo SET campo='certidao_conjuge',tipo='text',nome='CONJUGE',valor='',largura='470',mascara='',site='1',ordenacao='2',obrigatorio='0'
						WHERE id_servico_campo='272';
--18/05/2010 13:40:56
UPDATE vsites_servico_campo SET campo='certidao_pai',tipo='text',nome='PAI',valor='',largura='470',mascara='',site='1',ordenacao='3',obrigatorio='0'
						WHERE id_servico_campo='904';
--18/05/2010 13:40:56
UPDATE vsites_servico_campo SET campo='certidao_mae',tipo='text',nome='MAE',valor='',largura='470',mascara='',site='1',ordenacao='4',obrigatorio='0'
						WHERE id_servico_campo='638';
--18/05/2010 13:40:56
UPDATE vsites_servico_campo SET campo='certidao_data_casamento',tipo='text',nome='DATA DE CASAMENTO',valor='',largura='470',mascara='',site='1',ordenacao='5',obrigatorio='0'
						WHERE id_servico_campo='369';
--18/05/2010 13:40:56
UPDATE vsites_servico_campo SET campo='certidao_data_nascimento',tipo='text',nome='DATA DE NASCIMENTO',valor='',largura='470',mascara='',site='1',ordenacao='6',obrigatorio='0'
						WHERE id_servico_campo='1504';
--18/05/2010 13:40:56
UPDATE vsites_servico_campo SET campo='certidao_livro',tipo='text',nome='LIVRO',valor='',largura='470',mascara='',site='1',ordenacao='7',obrigatorio='0'
						WHERE id_servico_campo='616';
--18/05/2010 13:40:56
UPDATE vsites_servico_campo SET campo='certidao_folha',tipo='text',nome='FOLHA',valor='',largura='470',mascara='',site='1',ordenacao='8',obrigatorio='0'
						WHERE id_servico_campo='592';
--18/05/2010 13:40:57
UPDATE vsites_servico_campo SET campo='certidao_registro',tipo='text',nome='REGISTRO',valor='',largura='470',mascara='',site='1',ordenacao='9',obrigatorio='0'
						WHERE id_servico_campo='1041';
--18/05/2010 13:40:57
UPDATE vsites_servico_campo SET campo='certidao_cidade',tipo='text',nome='CIDADE',valor='',largura='470',mascara='',site='1',ordenacao='10',obrigatorio='1'
						WHERE id_servico_campo='105';
--18/05/2010 13:40:57
UPDATE vsites_servico_campo SET campo='certidao_estado',tipo='text',nome='ESTADO',valor='',largura='470',mascara='',site='1',ordenacao='11',obrigatorio='1'
						WHERE id_servico_campo='471';
--18/05/2010 13:40:58
UPDATE vsites_servico_campo SET campo='certidao_cartorio',tipo='text',nome='CARTÓRIO',valor='',largura='470',mascara='',site='1',ordenacao='12',obrigatorio='0'
						WHERE id_servico_campo='82';
--18/05/2010 13:40:58
UPDATE vsites_servico_campo SET campo='certidao_averbacao',tipo='text',nome='AVERBACAO',valor='',largura='470',mascara='',site='1',ordenacao='13',obrigatorio='0'
						WHERE id_servico_campo='2';
--18/05/2010 13:40:58
UPDATE vsites_servico_campo SET campo='certidao_finalidade',tipo='text',nome='FINALIDADE DO DOCUMENTO',valor='',largura='470',mascara='',site='1',ordenacao='14',obrigatorio='0'
						WHERE id_servico_campo='574';
--18/05/2010 13:40:58
DELETE FROM vsites_servico_campo WHERE id_servico_campo = '' AND id_servico='30';
--19/05/2010 11:34:27
UPDATE vsites_servico SET dias='', status='Inativo', descricao='Tributos Imobiliários', site='1' WHERE id_servico='136';
--19/05/2010 11:34:27
UPDATE vsites_servico_campo SET campo='certidao_nome',tipo='text',nome='NOME',valor='',largura='470',mascara='',site='1',ordenacao='1',obrigatorio='1'
						WHERE id_servico_campo='816';
--19/05/2010 11:34:27
UPDATE vsites_servico_campo SET campo='certidao_cidade',tipo='text',nome='CIDADE',valor='',largura='470',mascara='',site='1',ordenacao='2',obrigatorio='1'
						WHERE id_servico_campo='197';
--19/05/2010 11:34:27
UPDATE vsites_servico_campo SET campo='certidao_estado',tipo='text',nome='ESTADO',valor='',largura='470',mascara='',site='1',ordenacao='3',obrigatorio='1'
						WHERE id_servico_campo='561';
--19/05/2010 11:34:27
UPDATE vsites_servico_campo SET campo='certidao_cnpj',tipo='text',nome='CNPJ',valor='',largura='470',mascara='',site='1',ordenacao='4',obrigatorio='0'
						WHERE id_servico_campo='264';
--19/05/2010 11:34:28
UPDATE vsites_servico_campo SET campo='certidao_n_contribuinte',tipo='text',nome='N DO CONTRIBUINTE (IPTU)',valor='',largura='470',mascara='',site='1',ordenacao='5',obrigatorio='1'
						WHERE id_servico_campo='713';
--19/05/2010 11:34:28
DELETE FROM vsites_servico_campo WHERE id_servico_campo = '' AND id_servico='136';
--19/05/2010 11:36:23
UPDATE vsites_servico SET dias='', status='Ativo', descricao='Negativa do IPTU (Tributos Imobiliários)', site='1' WHERE id_servico='34';
--19/05/2010 11:36:24
UPDATE vsites_servico_campo SET campo='certidao_nome',tipo='text',nome='NOME',valor='',largura='470',mascara='',site='1',ordenacao='1',obrigatorio='1'
						WHERE id_servico_campo='788';
--19/05/2010 11:36:24
UPDATE vsites_servico_campo SET campo='certidao_cidade',tipo='text',nome='CIDADE',valor='',largura='470',mascara='',site='1',ordenacao='2',obrigatorio='1'
						WHERE id_servico_campo='166';
--19/05/2010 11:36:24
UPDATE vsites_servico_campo SET campo='certidao_estado',tipo='text',nome='ESTADO',valor='',largura='470',mascara='',site='1',ordenacao='3',obrigatorio='1'
						WHERE id_servico_campo='530';
--19/05/2010 11:36:24
UPDATE vsites_servico_campo SET campo='certidao_numero_contribuinte',tipo='text',nome='NUMERO DE CONTRIBUINTE',valor='',largura='470',mascara='',site='1',ordenacao='4',obrigatorio='1'
						WHERE id_servico_campo='840';
--19/05/2010 11:36:25
DELETE FROM vsites_servico_campo WHERE id_servico_campo = '' AND id_servico='34';
--26/05/2010 11:06:43
UPDATE vsites_servico SET dias='', status='Inativo', descricao='Baixa de Inscrição Municipal', site='1' WHERE id_servico='122';
--26/05/2010 11:06:43
UPDATE vsites_servico_campo SET campo='certidao_nome',tipo='text',nome='NOME',valor='',largura='470',mascara='',site='1',ordenacao='1',obrigatorio='0'
						WHERE id_servico_campo='734';
--26/05/2010 11:06:43
UPDATE vsites_servico_campo SET campo='certidao_cidade',tipo='text',nome='CIDADE',valor='',largura='470',mascara='',site='1',ordenacao='2',obrigatorio='0'
						WHERE id_servico_campo='112';
--26/05/2010 11:06:43
UPDATE vsites_servico_campo SET campo='certidao_estado',tipo='text',nome='ESTADO',valor='',largura='470',mascara='',site='1',ordenacao='3',obrigatorio='0'
						WHERE id_servico_campo='478';
--26/05/2010 11:06:43
UPDATE vsites_servico_campo SET campo='certidao_cnpj',tipo='text',nome='CNPJ',valor='',largura='470',mascara='',site='1',ordenacao='4',obrigatorio='0'
						WHERE id_servico_campo='212';
--26/05/2010 11:06:43
UPDATE vsites_servico_campo SET campo='certidao_numero_ccm',tipo='text',nome='NÚMERO DO CCM',valor='',largura='470',mascara='',site='1',ordenacao='5',obrigatorio='0'
						WHERE id_servico_campo='846';
--26/05/2010 11:06:43
DELETE FROM vsites_servico_campo WHERE id_servico_campo = '' AND id_servico='122';
--26/05/2010 11:14:19
UPDATE vsites_servico SET dias='', status='Ativo', descricao='Negativa de Protesto', site='1' WHERE id_servico='5';
--26/05/2010 11:14:19
UPDATE vsites_servico_campo SET campo='certidao_nome',tipo='text',nome='NOME',valor='',largura='470',mascara='',site='1',ordenacao='1',obrigatorio='1'
						WHERE id_servico_campo='787';
--26/05/2010 11:14:19
UPDATE vsites_servico_campo SET campo='certidao_rg',tipo='text',nome='RG',valor='',largura='470',mascara='',site='1',ordenacao='2',obrigatorio='0'
						WHERE id_servico_campo='1184';
--26/05/2010 11:14:19
UPDATE vsites_servico_campo SET campo='certidao_cpf',tipo='text',nome='CPF',valor='',largura='470',mascara='',site='1',ordenacao='3',obrigatorio='0'
						WHERE id_servico_campo='329';
--26/05/2010 11:14:20
UPDATE vsites_servico_campo SET campo='certidao_cnpj',tipo='text',nome='CNPJ',valor='',largura='470',mascara='',site='1',ordenacao='4',obrigatorio='0'
						WHERE id_servico_campo='243';
--26/05/2010 11:14:20
UPDATE vsites_servico_campo SET campo='certidao_cidade',tipo='text',nome='CIDADE',valor='',largura='470',mascara='',site='1',ordenacao='5',obrigatorio='1'
						WHERE id_servico_campo='165';
--26/05/2010 11:14:20
UPDATE vsites_servico_campo SET campo='certidao_estado',tipo='text',nome='ESTADO',valor='',largura='470',mascara='',site='1',ordenacao='6',obrigatorio='1'
						WHERE id_servico_campo='529';
--26/05/2010 11:14:20
UPDATE vsites_servico_campo SET campo='certidao_cartorio',tipo='text',nome='CARTORIO',valor='',largura='470',mascara='',site='1',ordenacao='7',obrigatorio='0'
						WHERE id_servico_campo='56';
--26/05/2010 11:14:20
DELETE FROM vsites_servico_campo WHERE id_servico_campo = '' AND id_servico='5';
--26/05/2010 11:15:18
UPDATE vsites_servico SET dias='', status='Ativo', descricao='Negativa de Protesto', site='1' WHERE id_servico='5';
--26/05/2010 11:15:18
UPDATE vsites_servico_campo SET campo='certidao_nome',tipo='text',nome='NOME',valor='',largura='470',mascara='',site='1',ordenacao='1',obrigatorio='1'
						WHERE id_servico_campo='787';
--26/05/2010 11:15:18
UPDATE vsites_servico_campo SET campo='certidao_rg',tipo='text',nome='RG',valor='',largura='470',mascara='',site='1',ordenacao='2',obrigatorio='0'
						WHERE id_servico_campo='1184';
--26/05/2010 11:15:19
UPDATE vsites_servico_campo SET campo='certidao_cpf',tipo='text',nome='CPF',valor='',largura='470',mascara='',site='1',ordenacao='3',obrigatorio='0'
						WHERE id_servico_campo='329';
--26/05/2010 11:15:19
UPDATE vsites_servico_campo SET campo='certidao_cnpj',tipo='text',nome='CNPJ',valor='',largura='470',mascara='',site='1',ordenacao='4',obrigatorio='0'
						WHERE id_servico_campo='243';
--26/05/2010 11:15:19
UPDATE vsites_servico_campo SET campo='certidao_cidade',tipo='text',nome='CIDADE',valor='',largura='470',mascara='',site='1',ordenacao='5',obrigatorio='1'
						WHERE id_servico_campo='165';
--26/05/2010 11:15:19
UPDATE vsites_servico_campo SET campo='certidao_estado',tipo='text',nome='ESTADO',valor='',largura='470',mascara='',site='1',ordenacao='6',obrigatorio='1'
						WHERE id_servico_campo='529';
--26/05/2010 11:15:19
UPDATE vsites_servico_campo SET campo='certidao_cartorio',tipo='text',nome='CARTORIO',valor='',largura='470',mascara='',site='1',ordenacao='7',obrigatorio='0'
						WHERE id_servico_campo='56';
--26/05/2010 11:15:19
INSERT INTO vsites_servico_campo (id_servico, campo, nome, tipo, largura, site, ordenacao) VALUES ('5','certidao_qtdd_cartorio','NUMERO DO CARTORIO','text','470','1','8');
--26/05/2010 11:15:20
DELETE FROM vsites_servico_campo WHERE id_servico_campo = '' AND id_servico='5';
--26/05/2010 11:19:09
UPDATE vsites_servico SET dias='', status='Ativo', descricao='Negativa de Protesto', site='1' WHERE id_servico='5';
--26/05/2010 11:19:09
UPDATE vsites_servico_campo SET campo='certidao_nome',tipo='text',nome='NOME',valor='',largura='470',mascara='',site='1',ordenacao='1',obrigatorio='1'
						WHERE id_servico_campo='787';
--26/05/2010 11:19:09
UPDATE vsites_servico_campo SET campo='certidao_rg',tipo='text',nome='RG',valor='',largura='470',mascara='',site='1',ordenacao='2',obrigatorio='0'
						WHERE id_servico_campo='1184';
--26/05/2010 11:19:10
UPDATE vsites_servico_campo SET campo='certidao_cpf',tipo='text',nome='CPF',valor='',largura='470',mascara='',site='1',ordenacao='3',obrigatorio='0'
						WHERE id_servico_campo='329';
--26/05/2010 11:19:10
UPDATE vsites_servico_campo SET campo='certidao_cnpj',tipo='text',nome='CNPJ',valor='',largura='470',mascara='',site='1',ordenacao='4',obrigatorio='0'
						WHERE id_servico_campo='243';
--26/05/2010 11:19:10
UPDATE vsites_servico_campo SET campo='certidao_cidade',tipo='text',nome='CIDADE',valor='',largura='470',mascara='',site='1',ordenacao='5',obrigatorio='1'
						WHERE id_servico_campo='165';
--26/05/2010 11:19:10
UPDATE vsites_servico_campo SET campo='certidao_estado',tipo='text',nome='ESTADO',valor='',largura='470',mascara='',site='1',ordenacao='6',obrigatorio='1'
						WHERE id_servico_campo='529';
--26/05/2010 11:19:10
UPDATE vsites_servico_campo SET campo='certidao_cartorio',tipo='text',nome='CARTORIO',valor='',largura='470',mascara='',site='1',ordenacao='7',obrigatorio='0'
						WHERE id_servico_campo='56';
--26/05/2010 11:19:10
UPDATE vsites_servico_campo SET campo='certidao_qtdd_cartorio',tipo='text',nome='NUMERO DO CARTORIO',valor='',largura='470',mascara='',site='1',ordenacao='8',obrigatorio='1'
						WHERE id_servico_campo='1596';
--26/05/2010 11:19:10
DELETE FROM vsites_servico_campo WHERE id_servico_campo = '' AND id_servico='5';
--26/05/2010 15:51:51
INSERT INTO vsites_servico (id_departamento, status, site, descricao) VALUES ('4','Ativo','1','Certidão de Prontuário do Detran');
--26/05/2010 15:51:52
INSERT INTO vsites_servico_campo (id_servico, campo, nome, tipo, largura, site, ordenacao) VALUES ('180','certidao_rg','RG','text','470','1','1');
--26/05/2010 15:51:52
INSERT INTO vsites_servico_campo (id_servico, campo, nome, tipo, largura, site, ordenacao) VALUES ('180','certidao_cnpj','CNPJ','text','470','1','2');
--26/05/2010 15:51:53
INSERT INTO vsites_servico_campo (id_servico, campo, nome, tipo, largura, site, ordenacao) VALUES ('180','certidao_cidade','CIDADE','text','470','1','3');
--26/05/2010 15:51:54
INSERT INTO vsites_servico_campo (id_servico, campo, nome, tipo, largura, site, ordenacao) VALUES ('180','certidao_estado','ESTADO','text','470','1','4');
--26/05/2010 15:53:33
UPDATE vsites_servico SET dias='', status='Ativo', descricao='Certidão de Prontuário do Detran', site='1' WHERE id_servico='180';
--26/05/2010 15:53:33
INSERT INTO vsites_servico_campo (id_servico, campo, nome, tipo, largura, site, ordenacao) VALUES ('180','certidao_nome','NOME','text','470','1','1');
--26/05/2010 15:53:33
UPDATE vsites_servico_campo SET campo='certidao_rg',tipo='text',nome='RG',valor='',largura='470',mascara='',site='1',ordenacao='2',obrigatorio='0'
						WHERE id_servico_campo='1597';
--26/05/2010 15:53:34
UPDATE vsites_servico_campo SET campo='certidao_cnpj',tipo='text',nome='CNPJ',valor='',largura='470',mascara='',site='1',ordenacao='3',obrigatorio='0'
						WHERE id_servico_campo='1598';
--26/05/2010 15:53:34
UPDATE vsites_servico_campo SET campo='certidao_cidade',tipo='text',nome='CIDADE',valor='',largura='470',mascara='',site='1',ordenacao='4',obrigatorio='1'
						WHERE id_servico_campo='1599';
--26/05/2010 15:53:35
UPDATE vsites_servico_campo SET campo='certidao_estado',tipo='text',nome='ESTADO',valor='',largura='470',mascara='',site='1',ordenacao='5',obrigatorio='1'
						WHERE id_servico_campo='1600';
--26/05/2010 15:53:36
DELETE FROM vsites_servico_campo WHERE id_servico_campo = '' AND id_servico='180';
--26/05/2010 15:55:04
UPDATE vsites_servico SET dias='', status='Ativo', descricao='Certidão de Prontuário do Detran', site='1' WHERE id_servico='180';
--26/05/2010 15:55:05
UPDATE vsites_servico_campo SET campo='certidao_nome',tipo='text',nome='NOME',valor='',largura='470',mascara='',site='1',ordenacao='1',obrigatorio='1'
						WHERE id_servico_campo='1601';
--26/05/2010 15:55:05
UPDATE vsites_servico_campo SET campo='certidao_rg',tipo='text',nome='RG',valor='',largura='470',mascara='',site='1',ordenacao='2',obrigatorio='0'
						WHERE id_servico_campo='1597';
--26/05/2010 15:55:06
INSERT INTO vsites_servico_campo (id_servico, campo, nome, tipo, largura, site, ordenacao) VALUES ('180','certidao_cpf','CPF','text','470','1','3');
--26/05/2010 15:55:07
UPDATE vsites_servico_campo SET campo='certidao_cnpj',tipo='text',nome='CNPJ',valor='',largura='470',mascara='',site='1',ordenacao='4',obrigatorio='0'
						WHERE id_servico_campo='1598';
--26/05/2010 15:55:08
UPDATE vsites_servico_campo SET campo='certidao_cidade',tipo='text',nome='CIDADE',valor='',largura='470',mascara='',site='1',ordenacao='5',obrigatorio='1'
						WHERE id_servico_campo='1599';
--26/05/2010 15:55:09
UPDATE vsites_servico_campo SET campo='certidao_estado',tipo='text',nome='ESTADO',valor='',largura='470',mascara='',site='1',ordenacao='6',obrigatorio='1'
						WHERE id_servico_campo='1600';
--26/05/2010 15:55:11
DELETE FROM vsites_servico_campo WHERE id_servico_campo = '' AND id_servico='180';
--26/05/2010 15:55:47
UPDATE vsites_servico SET dias='', status='Ativo', descricao='Certidão de Prontuário do Detran', site='1' WHERE id_servico='180';
--26/05/2010 15:55:48
UPDATE vsites_servico_campo SET campo='certidao_nome',tipo='text',nome='NOME',valor='',largura='470',mascara='',site='1',ordenacao='1',obrigatorio='1'
						WHERE id_servico_campo='1601';
--26/05/2010 15:55:49
UPDATE vsites_servico_campo SET campo='certidao_rg',tipo='text',nome='RG',valor='',largura='470',mascara='',site='1',ordenacao='2',obrigatorio='0'
						WHERE id_servico_campo='1597';
--26/05/2010 15:55:49
UPDATE vsites_servico_campo SET campo='certidao_cpf',tipo='text',nome='CPF',valor='',largura='470',mascara='',site='1',ordenacao='3',obrigatorio='0'
						WHERE id_servico_campo='1602';
--26/05/2010 15:55:50
UPDATE vsites_servico_campo SET campo='certidao_cnpj',tipo='text',nome='CNPJ',valor='',largura='470',mascara='',site='1',ordenacao='4',obrigatorio='0'
						WHERE id_servico_campo='1598';
--26/05/2010 15:55:50
UPDATE vsites_servico_campo SET campo='certidao_cidade',tipo='text',nome='CIDADE',valor='',largura='470',mascara='',site='1',ordenacao='5',obrigatorio='1'
						WHERE id_servico_campo='1599';
--26/05/2010 15:55:51
UPDATE vsites_servico_campo SET campo='certidao_estado',tipo='text',nome='ESTADO',valor='',largura='470',mascara='',site='1',ordenacao='6',obrigatorio='1'
						WHERE id_servico_campo='1600';
--26/05/2010 15:55:51
DELETE FROM vsites_servico_campo WHERE id_servico_campo = '' AND id_servico='180';
--27/05/2010 11:43:56
UPDATE vsites_servico SET dias='', status='Ativo', descricao='Anotação - Óbito', site='1' WHERE id_servico='30';
--27/05/2010 11:43:56
UPDATE vsites_servico_campo SET campo='certidao_nome',tipo='text',nome='NOME',valor='',largura='470',mascara='',site='1',ordenacao='1',obrigatorio='1'
						WHERE id_servico_campo='728';
--27/05/2010 11:43:56
UPDATE vsites_servico_campo SET campo='certidao_conjuge',tipo='text',nome='CONJUGE',valor='',largura='470',mascara='',site='1',ordenacao='2',obrigatorio='0'
						WHERE id_servico_campo='272';
--27/05/2010 11:43:56
UPDATE vsites_servico_campo SET campo='certidao_pai',tipo='text',nome='PAI',valor='',largura='470',mascara='',site='1',ordenacao='3',obrigatorio='0'
						WHERE id_servico_campo='904';
--27/05/2010 11:43:56
UPDATE vsites_servico_campo SET campo='certidao_mae',tipo='text',nome='MAE',valor='',largura='470',mascara='',site='1',ordenacao='4',obrigatorio='0'
						WHERE id_servico_campo='638';
--27/05/2010 11:43:56
UPDATE vsites_servico_campo SET campo='certidao_data_casamento',tipo='text',nome='DATA DE CASAMENTO',valor='',largura='470',mascara='',site='1',ordenacao='5',obrigatorio='0'
						WHERE id_servico_campo='369';
--27/05/2010 11:43:56
UPDATE vsites_servico_campo SET campo='certidao_data_nascimento',tipo='text',nome='DATA DE NASCIMENTO',valor='',largura='470',mascara='',site='1',ordenacao='6',obrigatorio='0'
						WHERE id_servico_campo='1504';
--27/05/2010 11:43:56
UPDATE vsites_servico_campo SET campo='certidao_livro',tipo='text',nome='LIVRO',valor='',largura='470',mascara='',site='1',ordenacao='7',obrigatorio='0'
						WHERE id_servico_campo='616';
--27/05/2010 11:43:56
UPDATE vsites_servico_campo SET campo='certidao_folha',tipo='text',nome='FOLHA',valor='',largura='470',mascara='',site='1',ordenacao='8',obrigatorio='0'
						WHERE id_servico_campo='592';
--27/05/2010 11:43:56
UPDATE vsites_servico_campo SET campo='certidao_registro',tipo='text',nome='REGISTRO',valor='',largura='470',mascara='',site='1',ordenacao='9',obrigatorio='0'
						WHERE id_servico_campo='1041';
--27/05/2010 11:43:56
UPDATE vsites_servico_campo SET campo='certidao_cidade',tipo='text',nome='CIDADE',valor='',largura='470',mascara='',site='1',ordenacao='10',obrigatorio='1'
						WHERE id_servico_campo='105';
--27/05/2010 11:43:56
UPDATE vsites_servico_campo SET campo='certidao_estado',tipo='text',nome='ESTADO',valor='',largura='470',mascara='',site='1',ordenacao='11',obrigatorio='1'
						WHERE id_servico_campo='471';
--27/05/2010 11:43:56
UPDATE vsites_servico_campo SET campo='certidao_cartorio',tipo='text',nome='CARTÓRIO',valor='',largura='470',mascara='',site='1',ordenacao='12',obrigatorio='0'
						WHERE id_servico_campo='82';
--27/05/2010 11:43:56
UPDATE vsites_servico_campo SET campo='certidao_averbacao',tipo='text',nome='AVERBACAO',valor='',largura='470',mascara='',site='1',ordenacao='13',obrigatorio='0'
						WHERE id_servico_campo='2';
--27/05/2010 11:43:56
UPDATE vsites_servico_campo SET campo='certidao_finalidade',tipo='text',nome='FINALIDADE DO DOCUMENTO',valor='',largura='470',mascara='',site='1',ordenacao='14',obrigatorio='0'
						WHERE id_servico_campo='574';
--27/05/2010 11:43:56
INSERT INTO vsites_servico_campo (id_servico, campo, nome, tipo, largura, site, ordenacao) VALUES ('30','certidao_data_registro','DATA DE REGISTRO','text','470','1','15');
--27/05/2010 11:43:56
DELETE FROM vsites_servico_campo WHERE id_servico_campo = '' AND id_servico='30';
--31/05/2010 14:49:36
UPDATE vsites_servico SET dias='', status='Ativo', descricao='Limpeza de Nome', site='1' WHERE id_servico='48';
--31/05/2010 14:49:36
UPDATE vsites_servico_campo SET campo='certidao_nome',tipo='text',nome='NOME',valor='',largura='470',mascara='',site='1',ordenacao='1',obrigatorio='1'
						WHERE id_servico_campo='783';
--31/05/2010 14:49:36
UPDATE vsites_servico_campo SET campo='certidao_rg',tipo='text',nome='RG',valor='',largura='470',mascara='',site='1',ordenacao='2',obrigatorio='0'
						WHERE id_servico_campo='1179';
--31/05/2010 14:49:36
UPDATE vsites_servico_campo SET campo='certidao_orgao_emissor',tipo='text',nome='ORGAO EMISSOR',valor='',largura='470',mascara='',site='1',ordenacao='3',obrigatorio='0'
						WHERE id_servico_campo='896';
--31/05/2010 14:49:37
UPDATE vsites_servico_campo SET campo='certidao_data_expedicao',tipo='text',nome='DATA DE EXPEDICAO',valor='',largura='470',mascara='',site='1',ordenacao='4',obrigatorio='0'
						WHERE id_servico_campo='378';
--31/05/2010 14:49:37
UPDATE vsites_servico_campo SET campo='certidao_cpf',tipo='text',nome='CPF',valor='',largura='470',mascara='',site='1',ordenacao='5',obrigatorio='0'
						WHERE id_servico_campo='326';
--31/05/2010 14:49:37
UPDATE vsites_servico_campo SET campo='certidao_cnpj',tipo='text',nome='CNPJ',valor='',largura='470',mascara='',site='1',ordenacao='6',obrigatorio='0'
						WHERE id_servico_campo='240';
--31/05/2010 14:49:37
UPDATE vsites_servico_campo SET campo='certidao_cidade',tipo='text',nome='CIDADE',valor='',largura='470',mascara='',site='1',ordenacao='7',obrigatorio='1'
						WHERE id_servico_campo='158';
--31/05/2010 14:49:40
UPDATE vsites_servico_campo SET campo='certidao_estado',tipo='text',nome='ESTADO',valor='',largura='470',mascara='',site='1',ordenacao='8',obrigatorio='1'
						WHERE id_servico_campo='523';
--31/05/2010 14:49:40
UPDATE vsites_servico_campo SET campo='certidao_cartorio',tipo='text',nome='CARTORIO',valor='',largura='470',mascara='',site='1',ordenacao='9',obrigatorio='0'
						WHERE id_servico_campo='50';
--31/05/2010 14:49:40
UPDATE vsites_servico_campo SET campo='certidao_protocolo',tipo='text',nome='PROTOCOLO',valor='',largura='470',mascara='',site='0',ordenacao='10',obrigatorio='0'
						WHERE id_servico_campo='997';
--31/05/2010 14:49:40
DELETE FROM vsites_servico_campo WHERE id_servico_campo = '' AND id_servico='48';
--08/06/2010 16:51:26
UPDATE vsites_servico SET dias='', status='Ativo', descricao='Certidão 1ª Instância', site='1' WHERE id_servico='176';
--08/06/2010 16:51:26
UPDATE vsites_servico_campo SET campo='certidao_nome',tipo='text',nome='Nome',valor='',largura='470',mascara='',site='1',ordenacao='1',obrigatorio='0'
						WHERE id_servico_campo='1492';
--08/06/2010 16:51:26
UPDATE vsites_servico_campo SET campo='certidao_rg',tipo='text',nome='RG',valor='',largura='470',mascara='',site='1',ordenacao='2',obrigatorio='0'
						WHERE id_servico_campo='1494';
--08/06/2010 16:51:26
UPDATE vsites_servico_campo SET campo='certidao_cpf',tipo='text',nome='CPF',valor='',largura='470',mascara='',site='1',ordenacao='3',obrigatorio='0'
						WHERE id_servico_campo='1495';
--08/06/2010 16:51:26
UPDATE vsites_servico_campo SET campo='certidao_cnpj',tipo='text',nome='CNPJ',valor='',largura='470',mascara='',site='1',ordenacao='4',obrigatorio='0'
						WHERE id_servico_campo='1496';
--08/06/2010 16:51:26
UPDATE vsites_servico_campo SET campo='certidao_endereco',tipo='text',nome='Endereço',valor='',largura='470',mascara='',site='1',ordenacao='5',obrigatorio='0'
						WHERE id_servico_campo='1493';
--08/06/2010 16:51:26
INSERT INTO vsites_servico_campo (id_servico, campo, nome, tipo, largura, site, ordenacao) VALUES ('176','certidao_cidade','CIDADE','text','470','1','6');
--08/06/2010 16:51:26
INSERT INTO vsites_servico_campo (id_servico, campo, nome, tipo, largura, site, ordenacao) VALUES ('176','certidao_estado','ESTADO','text','470','1','7');
--08/06/2010 16:51:26
DELETE FROM vsites_servico_campo WHERE id_servico_campo = '' AND id_servico='176';
--16/06/2010 12:02:11
UPDATE vsites_servico SET dias='', status='Ativo', descricao='Busca de Testamento', site='1' WHERE id_servico='134';
--16/06/2010 12:02:11
UPDATE vsites_servico_campo SET campo='certidao_nome',tipo='text',nome='NOME',valor='',largura='470',mascara='',site='1',ordenacao='1',obrigatorio='0'
						WHERE id_servico_campo='741';
--16/06/2010 12:02:11
UPDATE vsites_servico_campo SET campo='certidao_rg',tipo='text',nome='RG',valor='',largura='470',mascara='',site='1',ordenacao='2',obrigatorio='0'
						WHERE id_servico_campo='1144';
--16/06/2010 12:02:11
UPDATE vsites_servico_campo SET campo='certidao_cpf',tipo='text',nome='CPF',valor='',largura='470',mascara='',site='1',ordenacao='3',obrigatorio='0'
						WHERE id_servico_campo='293';
--16/06/2010 12:02:11
INSERT INTO vsites_servico_campo (id_servico, campo, nome, tipo, largura, site, ordenacao) VALUES ('134','certidao_cidade','CIDADE','text','470','1','4');
--16/06/2010 12:02:11
INSERT INTO vsites_servico_campo (id_servico, campo, nome, tipo, largura, site, ordenacao) VALUES ('134','certidao_estado','ESTADO','text','470','1','5');
--16/06/2010 12:02:11
UPDATE vsites_servico_campo SET campo='certidao_filiacao',tipo='text',nome='FILIACAO',valor='',largura='470',mascara='',site='1',ordenacao='6',obrigatorio='0'
						WHERE id_servico_campo='572';
--16/06/2010 12:02:11
UPDATE vsites_servico_campo SET campo='certidao_proposta',tipo='text',nome='PROPOSTA',valor='',largura='470',mascara='',site='1',ordenacao='7',obrigatorio='0'
						WHERE id_servico_campo='930';
--16/06/2010 12:02:11
UPDATE vsites_servico_campo SET campo='certidao_protocolo',tipo='text',nome='PROTOCOLO',valor='',largura='470',mascara='',site='0',ordenacao='8',obrigatorio='0'
						WHERE id_servico_campo='968';
--16/06/2010 12:02:11
DELETE FROM vsites_servico_campo WHERE id_servico_campo = '' AND id_servico='134';
--16/06/2010 12:02:45
UPDATE vsites_servico SET dias='', status='Ativo', descricao='Busca de Testamento', site='1' WHERE id_servico='134';
--16/06/2010 12:02:46
UPDATE vsites_servico_campo SET campo='certidao_nome',tipo='text',nome='NOME',valor='',largura='470',mascara='',site='1',ordenacao='1',obrigatorio='1'
						WHERE id_servico_campo='741';
--16/06/2010 12:02:46
UPDATE vsites_servico_campo SET campo='certidao_rg',tipo='text',nome='RG',valor='',largura='470',mascara='',site='1',ordenacao='2',obrigatorio='1'
						WHERE id_servico_campo='1144';
--16/06/2010 12:02:46
UPDATE vsites_servico_campo SET campo='certidao_cpf',tipo='text',nome='CPF',valor='',largura='470',mascara='',site='1',ordenacao='3',obrigatorio='1'
						WHERE id_servico_campo='293';
--16/06/2010 12:02:46
UPDATE vsites_servico_campo SET campo='certidao_cidade',tipo='text',nome='CIDADE',valor='',largura='470',mascara='',site='1',ordenacao='4',obrigatorio='1'
						WHERE id_servico_campo='1606';
--16/06/2010 12:02:46
UPDATE vsites_servico_campo SET campo='certidao_estado',tipo='text',nome='ESTADO',valor='',largura='470',mascara='',site='1',ordenacao='5',obrigatorio='1'
						WHERE id_servico_campo='1607';
--16/06/2010 12:02:46
UPDATE vsites_servico_campo SET campo='certidao_filiacao',tipo='text',nome='FILIACAO',valor='',largura='470',mascara='',site='1',ordenacao='6',obrigatorio='0'
						WHERE id_servico_campo='572';
--16/06/2010 12:02:46
UPDATE vsites_servico_campo SET campo='certidao_proposta',tipo='text',nome='PROPOSTA',valor='',largura='470',mascara='',site='1',ordenacao='7',obrigatorio='0'
						WHERE id_servico_campo='930';
--16/06/2010 12:02:46
UPDATE vsites_servico_campo SET campo='certidao_protocolo',tipo='text',nome='PROTOCOLO',valor='',largura='470',mascara='',site='0',ordenacao='8',obrigatorio='0'
						WHERE id_servico_campo='968';
--16/06/2010 12:02:46
DELETE FROM vsites_servico_campo WHERE id_servico_campo = '' AND id_servico='134';
--21/06/2010 09:36:05
UPDATE vsites_servico SET dias='', status='Inativo', descricao='Cópia Simples', site='1' WHERE id_servico='94';
--21/06/2010 09:36:05
UPDATE vsites_servico_campo SET campo='certidao_nome',tipo='text',nome='NOME',valor='',largura='470',mascara='',site='1',ordenacao='1',obrigatorio='1'
						WHERE id_servico_campo='756';
--21/06/2010 09:36:05
UPDATE vsites_servico_campo SET campo='certidao_rg',tipo='text',nome='RG',valor='',largura='470',mascara='',site='1',ordenacao='2',obrigatorio='0'
						WHERE id_servico_campo='1155';
--21/06/2010 09:36:06
UPDATE vsites_servico_campo SET campo='certidao_cpf',tipo='text',nome='CPF',valor='',largura='470',mascara='',site='1',ordenacao='3',obrigatorio='0'
						WHERE id_servico_campo='305';
--21/06/2010 09:36:06
UPDATE vsites_servico_campo SET campo='certidao_cnpj',tipo='text',nome='CNPJ',valor='',largura='470',mascara='',site='1',ordenacao='4',obrigatorio='0'
						WHERE id_servico_campo='226';
--21/06/2010 09:36:06
UPDATE vsites_servico_campo SET campo='certidao_cidade',tipo='text',nome='CIDADE',valor='',largura='470',mascara='',site='1',ordenacao='5',obrigatorio='1'
						WHERE id_servico_campo='133';
--21/06/2010 09:36:06
UPDATE vsites_servico_campo SET campo='certidao_estado',tipo='text',nome='ESTADO',valor='',largura='470',mascara='',site='1',ordenacao='6',obrigatorio='1'
						WHERE id_servico_campo='497';
--21/06/2010 09:36:06
UPDATE vsites_servico_campo SET campo='certidao_protocolo',tipo='text',nome='PROTOCOLO',valor='',largura='470',mascara='',site='0',ordenacao='7',obrigatorio='0'
						WHERE id_servico_campo='979';
--21/06/2010 09:36:07
DELETE FROM vsites_servico_campo WHERE id_servico_campo = '' AND id_servico='94';
--21/06/2010 09:36:41
UPDATE vsites_servico SET dias='', status='Inativo', descricao='Executivos Fiscais do Imovel - RJ', site='1' WHERE id_servico='107';
--21/06/2010 09:36:41
UPDATE vsites_servico_campo SET campo='certidao_cnpj',tipo='text',nome='CNPJ',valor='',largura='470',mascara='',site='0',ordenacao='1',obrigatorio='0'
						WHERE id_servico_campo='1245';
--21/06/2010 09:36:41
DELETE FROM vsites_servico_campo WHERE id_servico_campo = '' AND id_servico='107';
--21/06/2010 09:37:17
UPDATE vsites_servico SET dias='', status='Inativo', descricao='Juizado Especial Civel - MG', site='1' WHERE id_servico='127';
--21/06/2010 09:37:18
UPDATE vsites_servico_campo SET campo='certidao_nome',tipo='text',nome='NOME',valor='',largura='470',mascara='',site='1',ordenacao='1',obrigatorio='1'
						WHERE id_servico_campo='774';
--21/06/2010 09:37:18
UPDATE vsites_servico_campo SET campo='certidao_data_nascimento',tipo='text',nome='DATA DE NASCIMENTO',valor='',largura='470',mascara='',site='1',ordenacao='2',obrigatorio='0'
						WHERE id_servico_campo='399';
--21/06/2010 09:37:19
UPDATE vsites_servico_campo SET campo='certidao_rg',tipo='text',nome='RG',valor='',largura='470',mascara='',site='1',ordenacao='3',obrigatorio='0'
						WHERE id_servico_campo='1171';
--21/06/2010 09:37:19
UPDATE vsites_servico_campo SET campo='certidao_cpf',tipo='text',nome='CPF',valor='',largura='470',mascara='',site='1',ordenacao='4',obrigatorio='0'
						WHERE id_servico_campo='319';
--21/06/2010 09:37:20
UPDATE vsites_servico_campo SET campo='certidao_cnpj',tipo='text',nome='CNPJ',valor='',largura='470',mascara='',site='0',ordenacao='5',obrigatorio='0'
						WHERE id_servico_campo='1566';
--21/06/2010 09:37:20
UPDATE vsites_servico_campo SET campo='certidao_cidade',tipo='text',nome='CIDADE',valor='',largura='470',mascara='',site='1',ordenacao='6',obrigatorio='1'
						WHERE id_servico_campo='150';
--21/06/2010 09:37:20
UPDATE vsites_servico_campo SET campo='certidao_estado',tipo='text',nome='ESTADO',valor='',largura='470',mascara='',site='1',ordenacao='7',obrigatorio='1'
						WHERE id_servico_campo='514';
--21/06/2010 09:37:20
UPDATE vsites_servico_campo SET campo='certidao_mae',tipo='text',nome='MAE',valor='',largura='470',mascara='',site='1',ordenacao='8',obrigatorio='1'
						WHERE id_servico_campo='651';
--21/06/2010 09:37:21
UPDATE vsites_servico_campo SET campo='certidao_pai',tipo='text',nome='PAI',valor='',largura='470',mascara='',site='1',ordenacao='9',obrigatorio='0'
						WHERE id_servico_campo='917';
--21/06/2010 09:37:21
DELETE FROM vsites_servico_campo WHERE id_servico_campo = '' AND id_servico='127';
--21/06/2010 09:37:49
UPDATE vsites_servico SET dias='', status='Inativo', descricao='Juizado Especial Criminal - MG', site='1' WHERE id_servico='128';
--21/06/2010 09:37:49
UPDATE vsites_servico_campo SET campo='certidao_nome',tipo='text',nome='NOME',valor='',largura='470',mascara='',site='1',ordenacao='1',obrigatorio='1'
						WHERE id_servico_campo='775';
--21/06/2010 09:37:49
UPDATE vsites_servico_campo SET campo='certidao_data_nascimento',tipo='text',nome='DATA DE NASCIMENTO',valor='',largura='470',mascara='',site='1',ordenacao='2',obrigatorio='0'
						WHERE id_servico_campo='400';
--21/06/2010 09:37:49
UPDATE vsites_servico_campo SET campo='certidao_rg',tipo='text',nome='RG',valor='',largura='470',mascara='',site='1',ordenacao='3',obrigatorio='0'
						WHERE id_servico_campo='1172';
--21/06/2010 09:37:49
UPDATE vsites_servico_campo SET campo='certidao_orgao_emissor',tipo='text',nome='ORGÃO EMISSOR',valor='',largura='470',mascara='',site='0',ordenacao='4',obrigatorio='0'
						WHERE id_servico_campo='1567';
--21/06/2010 09:37:49
UPDATE vsites_servico_campo SET campo='certidao_cpf',tipo='text',nome='CPF',valor='',largura='470',mascara='',site='1',ordenacao='5',obrigatorio='0'
						WHERE id_servico_campo='320';
--21/06/2010 09:37:49
UPDATE vsites_servico_campo SET campo='certidao_cnpj',tipo='text',nome='CNPJ',valor='',largura='470',mascara='',site='0',ordenacao='6',obrigatorio='0'
						WHERE id_servico_campo='1568';
--21/06/2010 09:37:49
UPDATE vsites_servico_campo SET campo='certidao_cidade',tipo='text',nome='CIDADE',valor='',largura='470',mascara='',site='1',ordenacao='7',obrigatorio='1'
						WHERE id_servico_campo='151';
--21/06/2010 09:37:50
UPDATE vsites_servico_campo SET campo='certidao_estado',tipo='text',nome='ESTADO',valor='',largura='470',mascara='',site='1',ordenacao='8',obrigatorio='1'
						WHERE id_servico_campo='515';
--21/06/2010 09:37:50
UPDATE vsites_servico_campo SET campo='certidao_mae',tipo='text',nome='MAE',valor='',largura='470',mascara='',site='1',ordenacao='9',obrigatorio='1'
						WHERE id_servico_campo='652';
--21/06/2010 09:37:50
UPDATE vsites_servico_campo SET campo='certidao_pai',tipo='text',nome='PAI',valor='',largura='470',mascara='',site='1',ordenacao='10',obrigatorio='0'
						WHERE id_servico_campo='918';
--21/06/2010 09:37:50
DELETE FROM vsites_servico_campo WHERE id_servico_campo = '' AND id_servico='128';
--21/06/2010 09:39:31
UPDATE vsites_servico SET dias='', status='Ativo', descricao='Certidão 1ª Instância Criminal', site='1' WHERE id_servico='176';
--21/06/2010 09:39:31
UPDATE vsites_servico_campo SET campo='certidao_nome',tipo='text',nome='Nome',valor='',largura='470',mascara='',site='1',ordenacao='1',obrigatorio='0'
						WHERE id_servico_campo='1492';
--21/06/2010 09:39:32
UPDATE vsites_servico_campo SET campo='certidao_rg',tipo='text',nome='RG',valor='',largura='470',mascara='',site='1',ordenacao='2',obrigatorio='0'
						WHERE id_servico_campo='1494';
--21/06/2010 09:39:32
UPDATE vsites_servico_campo SET campo='certidao_cpf',tipo='text',nome='CPF',valor='',largura='470',mascara='',site='1',ordenacao='3',obrigatorio='0'
						WHERE id_servico_campo='1495';
--21/06/2010 09:39:32
UPDATE vsites_servico_campo SET campo='certidao_cnpj',tipo='text',nome='CNPJ',valor='',largura='470',mascara='',site='1',ordenacao='4',obrigatorio='0'
						WHERE id_servico_campo='1496';
--21/06/2010 09:39:32
UPDATE vsites_servico_campo SET campo='certidao_endereco',tipo='text',nome='Endereço',valor='',largura='470',mascara='',site='1',ordenacao='5',obrigatorio='0'
						WHERE id_servico_campo='1493';
--21/06/2010 09:39:32
UPDATE vsites_servico_campo SET campo='certidao_cidade',tipo='text',nome='CIDADE',valor='',largura='470',mascara='',site='1',ordenacao='6',obrigatorio='0'
						WHERE id_servico_campo='1604';
--21/06/2010 09:39:32
UPDATE vsites_servico_campo SET campo='certidao_estado',tipo='text',nome='ESTADO',valor='',largura='470',mascara='',site='1',ordenacao='7',obrigatorio='0'
						WHERE id_servico_campo='1605';
--21/06/2010 09:39:32
DELETE FROM vsites_servico_campo WHERE id_servico_campo = '' AND id_servico='176';
--21/06/2010 09:40:04
UPDATE vsites_servico SET dias='', status='Ativo', descricao='Quitação Fiscal do Imóvel', site='1' WHERE id_servico='100';
--21/06/2010 09:40:05
UPDATE vsites_servico_campo SET campo='certidao_nome',tipo='text',nome='NOME',valor='',largura='470',mascara='',site='1',ordenacao='1',obrigatorio='1'
						WHERE id_servico_campo='800';
--21/06/2010 09:40:06
UPDATE vsites_servico_campo SET campo='certidao_cpf',tipo='text',nome='CPF',valor='',largura='470',mascara='',site='1',ordenacao='2',obrigatorio='0'
						WHERE id_servico_campo='339';
--21/06/2010 09:40:07
UPDATE vsites_servico_campo SET campo='certidao_cnpj',tipo='text',nome='CNPJ',valor='',largura='470',mascara='',site='1',ordenacao='3',obrigatorio='0'
						WHERE id_servico_campo='252';
--21/06/2010 09:40:07
UPDATE vsites_servico_campo SET campo='certidao_cidade',tipo='text',nome='CIDADE',valor='',largura='470',mascara='',site='1',ordenacao='4',obrigatorio='1'
						WHERE id_servico_campo='179';
--21/06/2010 09:40:08
UPDATE vsites_servico_campo SET campo='certidao_estado',tipo='text',nome='ESTADO',valor='',largura='470',mascara='',site='1',ordenacao='5',obrigatorio='1'
						WHERE id_servico_campo='543';
--21/06/2010 09:40:09
UPDATE vsites_servico_campo SET campo='certidao_numero_contribuinte',tipo='text',nome='NUMERO DE CONTRIBUINTE',valor='',largura='470',mascara='',site='1',ordenacao='6',obrigatorio='1'
						WHERE id_servico_campo='841';
--21/06/2010 09:40:09
DELETE FROM vsites_servico_campo WHERE id_servico_campo = '' AND id_servico='100';
--21/06/2010 09:42:45
UPDATE vsites_servico SET dias='', status='Ativo', descricao='Situação Enfiteutica', site='1' WHERE id_servico='68';
--21/06/2010 09:42:45
UPDATE vsites_servico_campo SET campo='certidao_nome',tipo='text',nome='NOME',valor='',largura='470',mascara='',site='1',ordenacao='1',obrigatorio='1'
						WHERE id_servico_campo='812';
--21/06/2010 09:42:46
UPDATE vsites_servico_campo SET campo='certidao_cidade',tipo='text',nome='CIDADE',valor='',largura='470',mascara='',site='1',ordenacao='2',obrigatorio='1'
						WHERE id_servico_campo='192';
--21/06/2010 09:42:46
UPDATE vsites_servico_campo SET campo='certidao_estado',tipo='text',nome='ESTADO',valor='',largura='470',mascara='',site='1',ordenacao='3',obrigatorio='1'
						WHERE id_servico_campo='556';
--21/06/2010 09:42:46
UPDATE vsites_servico_campo SET campo='certidao_numero_contribuinte',tipo='text',nome='NUMERO DE CONTRIBUINTE',valor='',largura='470',mascara='',site='1',ordenacao='4',obrigatorio='0'
						WHERE id_servico_campo='842';
--21/06/2010 09:42:46
UPDATE vsites_servico_campo SET campo='certidao_protocolo',tipo='text',nome='PROTOCOLO',valor='',largura='470',mascara='',site='0',ordenacao='5',obrigatorio='0'
						WHERE id_servico_campo='1025';
--21/06/2010 09:42:46
DELETE FROM vsites_servico_campo WHERE id_servico_campo = '' AND id_servico='68';
--25/06/2010 09:24:51
INSERT INTO vsites_servico (id_departamento, status, site, descricao) VALUES ('4','Ativo','1','Certidão de Prontuário - DIRD');
--25/06/2010 09:24:51
INSERT INTO vsites_servico_campo (id_servico, campo, nome, tipo, largura, site, ordenacao) VALUES ('181','certidao_rg','RG','text','470','1','1');
--25/06/2010 09:24:52
INSERT INTO vsites_servico_campo (id_servico, campo, nome, tipo, largura, site, ordenacao) VALUES ('181','certidao_cpf','CPF','text','470','1','2');
--25/06/2010 09:24:53
INSERT INTO vsites_servico_campo (id_servico, campo, nome, tipo, largura, site, ordenacao) VALUES ('181','certidao_mae','MÃE','text','470','1','3');
--25/06/2010 09:24:53
INSERT INTO vsites_servico_campo (id_servico, campo, nome, tipo, largura, site, ordenacao) VALUES ('181','certidao_pai','PAI','text','470','1','4');
--25/06/2010 09:24:54
INSERT INTO vsites_servico_campo (id_servico, campo, nome, tipo, largura, site, ordenacao) VALUES ('181','certidao_data_nascimento','DATA DE NASCIMENTO','text','470','1','5');
--25/06/2010 09:24:54
INSERT INTO vsites_servico_campo (id_servico, campo, nome, tipo, largura, site, ordenacao) VALUES ('181','certidao_estado_civil','ESTADO CIVEL','text','470','1','6');
--25/06/2010 09:24:55
INSERT INTO vsites_servico_campo (id_servico, campo, nome, tipo, largura, site, ordenacao) VALUES ('181','certidao_profissao','PROFISSÃO','text','470','1','7');
--25/06/2010 09:24:56
INSERT INTO vsites_servico_campo (id_servico, campo, nome, tipo, largura, site, ordenacao) VALUES ('181','certidao_endereco','ENDEREÇO','text','470','1','8');
--25/06/2010 09:24:56
INSERT INTO vsites_servico_campo (id_servico, campo, nome, tipo, largura, site, ordenacao) VALUES ('181','certidao_numero','NUMERO','text','470','1','9');
--25/06/2010 09:24:57
INSERT INTO vsites_servico_campo (id_servico, campo, nome, tipo, largura, site, ordenacao) VALUES ('181','c_bairro','BAIRRO','text','470','1','10');
--25/06/2010 09:24:57
INSERT INTO vsites_servico_campo (id_servico, campo, nome, tipo, largura, site, ordenacao) VALUES ('181','certidao_cidade','CIDADE','text','470','1','11');
--25/06/2010 09:24:58
INSERT INTO vsites_servico_campo (id_servico, campo, nome, tipo, largura, site, ordenacao) VALUES ('181','certidao_estado','ESTADO','text','470','1','12');
--25/06/2010 09:24:59
INSERT INTO vsites_servico_campo (id_servico, campo, nome, tipo, largura, site, ordenacao) VALUES ('181','c_tel','TELEFONE','text','470','1','13');
--25/06/2010 09:25:00
INSERT INTO vsites_servico_campo (id_servico, campo, nome, tipo, largura, site, ordenacao) VALUES ('181','certidao_finalidade','FINALIDADE','text','470','1','14');
--25/06/2010 09:25:35
UPDATE vsites_servico SET dias='', status='Ativo', descricao='Certidão de Prontuário - DIRD', site='1' WHERE id_servico='181';
--25/06/2010 09:25:35
UPDATE vsites_servico_campo SET campo='certidao_rg',tipo='text',nome='RG',valor='',largura='470',mascara='',site='1',ordenacao='1',obrigatorio='1'
						WHERE id_servico_campo='1608';
--25/06/2010 09:25:36
UPDATE vsites_servico_campo SET campo='certidao_cpf',tipo='text',nome='CPF',valor='',largura='470',mascara='',site='1',ordenacao='2',obrigatorio='1'
						WHERE id_servico_campo='1609';
--25/06/2010 09:25:36
UPDATE vsites_servico_campo SET campo='certidao_mae',tipo='text',nome='MÃE',valor='',largura='470',mascara='',site='1',ordenacao='3',obrigatorio='1'
						WHERE id_servico_campo='1610';
--25/06/2010 09:25:37
UPDATE vsites_servico_campo SET campo='certidao_pai',tipo='text',nome='PAI',valor='',largura='470',mascara='',site='1',ordenacao='4',obrigatorio='1'
						WHERE id_servico_campo='1611';
--25/06/2010 09:25:38
UPDATE vsites_servico_campo SET campo='certidao_data_nascimento',tipo='text',nome='DATA DE NASCIMENTO',valor='',largura='470',mascara='',site='1',ordenacao='5',obrigatorio='1'
						WHERE id_servico_campo='1612';
--25/06/2010 09:25:39
UPDATE vsites_servico_campo SET campo='certidao_estado_civil',tipo='text',nome='ESTADO CIVEL',valor='',largura='470',mascara='',site='1',ordenacao='6',obrigatorio='1'
						WHERE id_servico_campo='1613';
--25/06/2010 09:25:40
UPDATE vsites_servico_campo SET campo='certidao_profissao',tipo='text',nome='PROFISSÃO',valor='',largura='470',mascara='',site='1',ordenacao='7',obrigatorio='1'
						WHERE id_servico_campo='1614';
--25/06/2010 09:25:41
UPDATE vsites_servico_campo SET campo='certidao_endereco',tipo='text',nome='ENDEREÇO',valor='',largura='470',mascara='',site='1',ordenacao='8',obrigatorio='1'
						WHERE id_servico_campo='1615';
--25/06/2010 09:25:41
UPDATE vsites_servico_campo SET campo='certidao_numero',tipo='text',nome='NUMERO',valor='',largura='470',mascara='',site='1',ordenacao='9',obrigatorio='1'
						WHERE id_servico_campo='1616';
--25/06/2010 09:25:42
UPDATE vsites_servico_campo SET campo='c_bairro',tipo='text',nome='BAIRRO',valor='',largura='470',mascara='',site='1',ordenacao='10',obrigatorio='1'
						WHERE id_servico_campo='1617';
--25/06/2010 09:25:43
UPDATE vsites_servico_campo SET campo='certidao_cidade',tipo='text',nome='CIDADE',valor='',largura='470',mascara='',site='1',ordenacao='11',obrigatorio='1'
						WHERE id_servico_campo='1618';
--25/06/2010 09:25:43
UPDATE vsites_servico_campo SET campo='certidao_estado',tipo='text',nome='ESTADO',valor='',largura='470',mascara='',site='1',ordenacao='12',obrigatorio='1'
						WHERE id_servico_campo='1619';
--25/06/2010 09:25:44
UPDATE vsites_servico_campo SET campo='c_tel',tipo='text',nome='TELEFONE',valor='',largura='470',mascara='',site='1',ordenacao='13',obrigatorio='1'
						WHERE id_servico_campo='1620';
--25/06/2010 09:25:45
UPDATE vsites_servico_campo SET campo='certidao_finalidade',tipo='text',nome='FINALIDADE',valor='',largura='470',mascara='',site='1',ordenacao='14',obrigatorio='1'
						WHERE id_servico_campo='1621';
--25/06/2010 09:25:45
DELETE FROM vsites_servico_campo WHERE id_servico_campo = '' AND id_servico='181';
--25/06/2010 09:26:08
UPDATE vsites_servico SET dias='', status='Ativo', descricao='Certidão de Prontuário - DIRD', site='1' WHERE id_servico='181';
--25/06/2010 09:26:11
UPDATE vsites_servico_campo SET campo='certidao_rg',tipo='text',nome='RG',valor='',largura='470',mascara='',site='1',ordenacao='1',obrigatorio='1'
						WHERE id_servico_campo='1608';
--25/06/2010 09:26:11
UPDATE vsites_servico_campo SET campo='certidao_cpf',tipo='text',nome='CPF',valor='',largura='470',mascara='',site='1',ordenacao='2',obrigatorio='1'
						WHERE id_servico_campo='1609';
--25/06/2010 09:26:12
UPDATE vsites_servico_campo SET campo='certidao_mae',tipo='text',nome='MÃE',valor='',largura='470',mascara='',site='1',ordenacao='3',obrigatorio='1'
						WHERE id_servico_campo='1610';
--25/06/2010 09:26:13
UPDATE vsites_servico_campo SET campo='certidao_pai',tipo='text',nome='PAI',valor='',largura='470',mascara='',site='1',ordenacao='4',obrigatorio='1'
						WHERE id_servico_campo='1611';
--25/06/2010 09:26:14
UPDATE vsites_servico_campo SET campo='certidao_data_nascimento',tipo='text',nome='DATA DE NASCIMENTO',valor='',largura='470',mascara='',site='1',ordenacao='5',obrigatorio='1'
						WHERE id_servico_campo='1612';
--25/06/2010 09:26:14
UPDATE vsites_servico_campo SET campo='certidao_estado_civil',tipo='text',nome='ESTADO CIVEL',valor='',largura='470',mascara='',site='1',ordenacao='6',obrigatorio='1'
						WHERE id_servico_campo='1613';
--25/06/2010 09:26:15
UPDATE vsites_servico_campo SET campo='certidao_profissao',tipo='text',nome='PROFISSÃO',valor='',largura='470',mascara='',site='1',ordenacao='7',obrigatorio='1'
						WHERE id_servico_campo='1614';
--25/06/2010 09:26:16
UPDATE vsites_servico_campo SET campo='certidao_endereco',tipo='text',nome='ENDEREÇO',valor='',largura='470',mascara='',site='1',ordenacao='8',obrigatorio='1'
						WHERE id_servico_campo='1615';
--25/06/2010 09:26:17
UPDATE vsites_servico_campo SET campo='certidao_numero',tipo='text',nome='NUMERO',valor='',largura='470',mascara='',site='1',ordenacao='9',obrigatorio='1'
						WHERE id_servico_campo='1616';
--25/06/2010 09:26:17
UPDATE vsites_servico_campo SET campo='c_bairro',tipo='text',nome='BAIRRO',valor='',largura='470',mascara='',site='1',ordenacao='10',obrigatorio='1'
						WHERE id_servico_campo='1617';
--25/06/2010 09:26:18
UPDATE vsites_servico_campo SET campo='certidao_cidade',tipo='text',nome='CIDADE',valor='',largura='470',mascara='',site='1',ordenacao='11',obrigatorio='1'
						WHERE id_servico_campo='1618';
--25/06/2010 09:26:19
UPDATE vsites_servico_campo SET campo='certidao_estado',tipo='text',nome='ESTADO',valor='',largura='470',mascara='',site='1',ordenacao='12',obrigatorio='1'
						WHERE id_servico_campo='1619';
--25/06/2010 09:26:20
UPDATE vsites_servico_campo SET campo='c_tel',tipo='text',nome='TELEFONE',valor='',largura='470',mascara='',site='1',ordenacao='13',obrigatorio='1'
						WHERE id_servico_campo='1620';
--25/06/2010 09:26:20
UPDATE vsites_servico_campo SET campo='certidao_finalidade',tipo='text',nome='FINALIDADE',valor='',largura='470',mascara='',site='1',ordenacao='14',obrigatorio='1'
						WHERE id_servico_campo='1621';
--25/06/2010 09:26:21
DELETE FROM vsites_servico_campo WHERE id_servico_campo = '' AND id_servico='181';
--28/06/2010 11:21:19
INSERT INTO vsites_servico (id_departamento, status, site, descricao) VALUES ('7','Inativo','1','Cópia do Contrato Padrão de Compra e Venda');
--28/06/2010 11:21:19
INSERT INTO vsites_servico_campo (id_servico, campo, nome, tipo, largura, site, ordenacao) VALUES ('182','certidao_cartorio','CARTÓRIO','text','470','1','1');
--28/06/2010 11:21:19
INSERT INTO vsites_servico_campo (id_servico, campo, nome, tipo, largura, site, ordenacao) VALUES ('182','certidao_numero','NÚMERO','text','470','1','2');
--28/06/2010 11:21:20
INSERT INTO vsites_servico_campo (id_servico, campo, nome, tipo, largura, site, ordenacao) VALUES ('182','certidao_campo_bairro','BAIRRO','text','470','1','3');
--28/06/2010 11:21:20
INSERT INTO vsites_servico_campo (id_servico, campo, nome, tipo, largura, site, ordenacao) VALUES ('182','certidao_campo_cep','CEP','text','470','1','4');
--28/06/2010 11:21:20
INSERT INTO vsites_servico_campo (id_servico, campo, nome, tipo, largura, site, ordenacao) VALUES ('182','certidao_cidade','CIDADE','text','470','1','5');
--28/06/2010 11:21:20
INSERT INTO vsites_servico_campo (id_servico, campo, nome, tipo, largura, site, ordenacao) VALUES ('182','certidao_estado','UF','text','470','1','6');
--28/06/2010 11:23:31
UPDATE vsites_servico SET dias='', status='Inativo', descricao='Cópia do Contrato Padrão de Compra e Venda', site='1' WHERE id_servico='182';
--28/06/2010 11:23:31
UPDATE vsites_servico_campo SET campo='certidao_cartorio',tipo='text',nome='CARTÓRIO',valor='',largura='470',mascara='',site='1',ordenacao='1',obrigatorio='1'
						WHERE id_servico_campo='1622';
--28/06/2010 11:23:31
INSERT INTO vsites_servico_campo (id_servico, campo, nome, tipo, largura, site, ordenacao) VALUES ('182','certidao_endereco','LOGRADOURO DO IMÓVEL','text','470','1','2');
--28/06/2010 11:23:32
UPDATE vsites_servico_campo SET campo='certidao_numero',tipo='text',nome='NÚMERO',valor='',largura='470',mascara='',site='1',ordenacao='3',obrigatorio='1'
						WHERE id_servico_campo='1623';
--28/06/2010 11:23:32
UPDATE vsites_servico_campo SET campo='certidao_campo_bairro',tipo='text',nome='BAIRRO',valor='',largura='470',mascara='',site='1',ordenacao='4',obrigatorio='1'
						WHERE id_servico_campo='1624';
--28/06/2010 11:23:32
UPDATE vsites_servico_campo SET campo='certidao_campo_cep',tipo='text',nome='CEP',valor='',largura='470',mascara='',site='1',ordenacao='5',obrigatorio='0'
						WHERE id_servico_campo='1625';
--28/06/2010 11:23:32
UPDATE vsites_servico_campo SET campo='certidao_cidade',tipo='text',nome='CIDADE',valor='',largura='470',mascara='',site='1',ordenacao='6',obrigatorio='1'
						WHERE id_servico_campo='1626';
--28/06/2010 11:23:32
UPDATE vsites_servico_campo SET campo='certidao_estado',tipo='text',nome='UF',valor='',largura='470',mascara='',site='1',ordenacao='7',obrigatorio='1'
						WHERE id_servico_campo='1627';
--28/06/2010 11:23:32
DELETE FROM vsites_servico_campo WHERE id_servico_campo = '' AND id_servico='182';
--28/06/2010 11:23:47
UPDATE vsites_servico SET dias='', status='Inativo', descricao='Cópia do Contrato Padrão de Compra e Venda', site='1' WHERE id_servico='182';
--28/06/2010 11:23:47
UPDATE vsites_servico_campo SET campo='certidao_cartorio',tipo='text',nome='CARTÓRIO',valor='',largura='470',mascara='',site='1',ordenacao='1',obrigatorio='1'
						WHERE id_servico_campo='1622';
--28/06/2010 11:23:47
UPDATE vsites_servico_campo SET campo='certidao_endereco',tipo='text',nome='LOGRADOURO DO IMÓVEL',valor='',largura='470',mascara='',site='1',ordenacao='2',obrigatorio='1'
						WHERE id_servico_campo='1628';
--28/06/2010 11:23:47
UPDATE vsites_servico_campo SET campo='certidao_numero',tipo='text',nome='NÚMERO',valor='',largura='470',mascara='',site='1',ordenacao='3',obrigatorio='1'
						WHERE id_servico_campo='1623';
--28/06/2010 11:23:47
UPDATE vsites_servico_campo SET campo='certidao_campo_bairro',tipo='text',nome='BAIRRO',valor='',largura='470',mascara='',site='1',ordenacao='4',obrigatorio='1'
						WHERE id_servico_campo='1624';
--28/06/2010 11:23:47
UPDATE vsites_servico_campo SET campo='certidao_campo_cep',tipo='text',nome='CEP',valor='',largura='470',mascara='',site='1',ordenacao='5',obrigatorio='0'
						WHERE id_servico_campo='1625';
--28/06/2010 11:23:47
UPDATE vsites_servico_campo SET campo='certidao_cidade',tipo='text',nome='CIDADE',valor='',largura='470',mascara='',site='1',ordenacao='6',obrigatorio='1'
						WHERE id_servico_campo='1626';
--28/06/2010 11:23:47
UPDATE vsites_servico_campo SET campo='certidao_estado',tipo='text',nome='UF',valor='',largura='470',mascara='',site='1',ordenacao='7',obrigatorio='1'
						WHERE id_servico_campo='1627';
--28/06/2010 11:23:47
DELETE FROM vsites_servico_campo WHERE id_servico_campo = '' AND id_servico='182';
--28/06/2010 11:47:48
UPDATE vsites_servico SET dias='', status='Ativo', descricao='Cópia do Contrato Padrão de Compra e Venda', site='1' WHERE id_servico='182';
--28/06/2010 11:47:49
UPDATE vsites_servico_campo SET campo='certidao_cartorio',tipo='text',nome='CARTÓRIO',valor='',largura='470',mascara='',site='1',ordenacao='1',obrigatorio='1'
						WHERE id_servico_campo='1622';
--28/06/2010 11:47:50
UPDATE vsites_servico_campo SET campo='certidao_endereco',tipo='text',nome='LOGRADOURO DO IMÓVEL',valor='',largura='470',mascara='',site='1',ordenacao='2',obrigatorio='1'
						WHERE id_servico_campo='1628';
--28/06/2010 11:47:51
UPDATE vsites_servico_campo SET campo='certidao_numero',tipo='text',nome='NÚMERO',valor='',largura='470',mascara='',site='1',ordenacao='3',obrigatorio='1'
						WHERE id_servico_campo='1623';
--28/06/2010 11:47:52
UPDATE vsites_servico_campo SET campo='certidao_campo_bairro',tipo='text',nome='BAIRRO',valor='',largura='470',mascara='',site='1',ordenacao='4',obrigatorio='1'
						WHERE id_servico_campo='1624';
--28/06/2010 11:47:53
UPDATE vsites_servico_campo SET campo='certidao_campo_cep',tipo='text',nome='CEP',valor='',largura='470',mascara='',site='1',ordenacao='5',obrigatorio='0'
						WHERE id_servico_campo='1625';
--28/06/2010 11:47:54
UPDATE vsites_servico_campo SET campo='certidao_cidade',tipo='text',nome='CIDADE',valor='',largura='470',mascara='',site='1',ordenacao='6',obrigatorio='1'
						WHERE id_servico_campo='1626';
--28/06/2010 11:47:55
UPDATE vsites_servico_campo SET campo='certidao_estado',tipo='text',nome='UF',valor='',largura='470',mascara='',site='1',ordenacao='7',obrigatorio='1'
						WHERE id_servico_campo='1627';
--28/06/2010 11:47:56
DELETE FROM vsites_servico_campo WHERE id_servico_campo = '' AND id_servico='182';
--22/07/2010 11:40:51
UPDATE vsites_servico SET dias='', status='Ativo', descricao='Cidadania', site='1' WHERE id_servico='78';
--22/07/2010 11:40:52
UPDATE vsites_servico_campo SET campo='certidao_nome',tipo='text',nome='NOME',valor='',largura='470',mascara='',site='1',ordenacao='1',obrigatorio='0'
						WHERE id_servico_campo='747';
--22/07/2010 11:40:52
UPDATE vsites_servico_campo SET campo='certidao_pai',tipo='text',nome='PAI',valor='',largura='470',mascara='',site='1',ordenacao='2',obrigatorio='0'
						WHERE id_servico_campo='908';
--22/07/2010 11:40:52
UPDATE vsites_servico_campo SET campo='certidao_mae',tipo='text',nome='MAE',valor='',largura='470',mascara='',site='1',ordenacao='3',obrigatorio='0'
						WHERE id_servico_campo='642';
--22/07/2010 11:40:52
UPDATE vsites_servico_campo SET campo='certidao_cidade',tipo='text',nome='CIDADE',valor='',largura='470',mascara='',site='1',ordenacao='4',obrigatorio='0'
						WHERE id_servico_campo='124';
--22/07/2010 11:40:53
UPDATE vsites_servico_campo SET campo='certidao_existe_certidao_obito',tipo='text',nome='EXISTE CERTIDAO DE OBITO',valor='',largura='470',mascara='',site='1',ordenacao='5',obrigatorio='0'
						WHERE id_servico_campo='571';
--22/07/2010 11:40:53
UPDATE vsites_servico_campo SET campo='certidao_data_nascimento',tipo='text',nome='DATA DE NASCIMENTO',valor='',largura='470',mascara='',site='1',ordenacao='6',obrigatorio='0'
						WHERE id_servico_campo='388';
--22/07/2010 11:40:53
UPDATE vsites_servico_campo SET campo='certidao_data_nascimento',tipo='text',nome='DATA DE NASCIMENTO',valor='',largura='470',mascara='',site='1',ordenacao='7',obrigatorio='0'
						WHERE id_servico_campo='411';
--22/07/2010 11:40:53
UPDATE vsites_servico_campo SET campo='certidao_nome_estrangeiro',tipo='text',nome='NOME DO ESTRANGEIRO',valor='',largura='470',mascara='',site='1',ordenacao='8',obrigatorio='0'
						WHERE id_servico_campo='826';
--22/07/2010 11:40:53
UPDATE vsites_servico_campo SET campo='certidao_naturalizado',tipo='text',nome='E NATURALIZADO (sim ou não)',valor='',largura='470',mascara='',site='1',ordenacao='9',obrigatorio='0'
						WHERE id_servico_campo='432';
--22/07/2010 11:40:53
UPDATE vsites_servico_campo SET campo='certidao_protocolo',tipo='text',nome='PROVINCIA OU CIDADE DE',valor='',largura='470',mascara='',site='0',ordenacao='10',obrigatorio='0'
						WHERE id_servico_campo='1033';
--22/07/2010 11:40:53
UPDATE vsites_servico_campo SET campo='certidao_filiacao',tipo='text',nome='FILIACAO',valor='',largura='470',mascara='',site='1',ordenacao='11',obrigatorio='0'
						WHERE id_servico_campo='573';
--22/07/2010 11:40:53
UPDATE vsites_servico_campo SET campo='certidao_existe_certidao_de2',tipo='text',nome='EXISTE CERTIDAO DE',valor='',largura='470',mascara='',site='1',ordenacao='12',obrigatorio='0'
						WHERE id_servico_campo='570';
--22/07/2010 11:40:53
UPDATE vsites_servico_campo SET campo='certidao_existe_certidao_de1',tipo='text',nome='EXISTE CERTIDAO DE',valor='',largura='470',mascara='',site='1',ordenacao='13',obrigatorio='0'
						WHERE id_servico_campo='569';
--22/07/2010 11:40:53
UPDATE vsites_servico_campo SET campo='certidao_data_naturalizacao',tipo='text',nome='DATA DE NATURALIZAÇÃO',valor='',largura='470',mascara='',site='1',ordenacao='14',obrigatorio='0'
						WHERE id_servico_campo='412';
--22/07/2010 11:40:53
UPDATE vsites_servico_campo SET campo='certidao_data_desembarque',tipo='text',nome='DATA DE DESEMBARQUE DO',valor='',largura='470',mascara='',site='1',ordenacao='15',obrigatorio='0'
						WHERE id_servico_campo='370';
--22/07/2010 11:40:53
UPDATE vsites_servico_campo SET campo='certidao_cidade_do_estrangeiro',tipo='text',nome='CIDADE DO ESTRANGEIRO',valor='',largura='470',mascara='',site='1',ordenacao='16',obrigatorio='0'
						WHERE id_servico_campo='204';
--22/07/2010 11:40:53
UPDATE vsites_servico_campo SET campo='certidao_provincia_regiao',tipo='text',nome='PROVINCIA REGIAO DO',valor='',largura='470',mascara='',site='1',ordenacao='17',obrigatorio='0'
						WHERE id_servico_campo='1035';
--22/07/2010 11:40:53
DELETE FROM vsites_servico_campo WHERE id_servico_campo = '' AND id_servico='78';
--22/07/2010 13:36:42
UPDATE vsites_servico SET dias='', status='Ativo', descricao='Tutela e Curatela', site='1' WHERE id_servico='67';
--22/07/2010 13:36:42
UPDATE vsites_servico_campo SET campo='certidao_nome',tipo='text',nome='NOME',valor='',largura='470',mascara='',site='1',ordenacao='1',obrigatorio='1'
						WHERE id_servico_campo='819';
--22/07/2010 13:36:42
INSERT INTO vsites_servico_campo (id_servico, campo, nome, tipo, largura, site, ordenacao) VALUES ('67','certidao_data_nascimento','DATA NASCIMENTO','text','470','1','2');
--22/07/2010 13:36:42
UPDATE vsites_servico_campo SET campo='certidao_orgao_emissor',tipo='text',nome='ORGAO EMISSOR',valor='',largura='470',mascara='',site='1',ordenacao='3',obrigatorio='1'
						WHERE id_servico_campo='901';
--22/07/2010 13:36:42
UPDATE vsites_servico_campo SET campo='certidao_rg',tipo='text',nome='RG',valor='',largura='470',mascara='',site='1',ordenacao='4',obrigatorio='1'
						WHERE id_servico_campo='1205';
--22/07/2010 13:36:42
UPDATE vsites_servico_campo SET campo='certidao_data_expedicao',tipo='text',nome='DATA DE EXPEDICAO',valor='',largura='470',mascara='',site='1',ordenacao='5',obrigatorio='1'
						WHERE id_servico_campo='383';
--22/07/2010 13:36:42
UPDATE vsites_servico_campo SET campo='certidao_cpf',tipo='text',nome='CPF',valor='',largura='470',mascara='',site='1',ordenacao='6',obrigatorio='1'
						WHERE id_servico_campo='353';
--22/07/2010 13:36:42
UPDATE vsites_servico_campo SET campo='certidao_nacionalidade',tipo='text',nome='NATURALIDADE',valor='',largura='470',mascara='',site='1',ordenacao='7',obrigatorio='1'
						WHERE id_servico_campo='722';
--22/07/2010 13:36:42
UPDATE vsites_servico_campo SET campo='certidao_cidade',tipo='text',nome='CIDADE',valor='',largura='470',mascara='',site='1',ordenacao='8',obrigatorio='1'
						WHERE id_servico_campo='200';
--22/07/2010 13:36:43
UPDATE vsites_servico_campo SET campo='certidao_estado',tipo='text',nome='ESTADO',valor='',largura='470',mascara='',site='1',ordenacao='9',obrigatorio='1'
						WHERE id_servico_campo='564';
--22/07/2010 13:36:43
UPDATE vsites_servico_campo SET campo='certidao_mae',tipo='text',nome='MAE',valor='',largura='470',mascara='',site='1',ordenacao='10',obrigatorio='1'
						WHERE id_servico_campo='660';
--22/07/2010 13:36:43
UPDATE vsites_servico_campo SET campo='certidao_pai',tipo='text',nome='PAI',valor='',largura='470',mascara='',site='1',ordenacao='11',obrigatorio='0'
						WHERE id_servico_campo='926';
--22/07/2010 13:36:43
UPDATE vsites_servico_campo SET campo='certidao_finalidade',tipo='text',nome='FINALIDADE',valor='',largura='470',mascara='',site='1',ordenacao='12',obrigatorio='0'
						WHERE id_servico_campo='1552';
--22/07/2010 13:36:43
DELETE FROM vsites_servico_campo WHERE id_servico_campo = '' AND id_servico='67';
--02/08/2010 09:07:16
UPDATE vsites_servico SET dias='', status='Ativo', descricao='Outros Serviços', site='1' WHERE id_servico='80';
--02/08/2010 09:07:17
UPDATE vsites_servico_campo SET campo='certidao_nome_proprietario',tipo='text',nome='NOME DO PROPRIETÁRIO',valor='',largura='470',mascara='',site='1',ordenacao='1',obrigatorio='0'
						WHERE id_servico_campo='832';
--02/08/2010 09:07:17
UPDATE vsites_servico_campo SET campo='certidao_rg',tipo='text',nome='RG',valor='',largura='470',mascara='',site='1',ordenacao='2',obrigatorio='0'
						WHERE id_servico_campo='1200';
--02/08/2010 09:07:18
UPDATE vsites_servico_campo SET campo='certidao_cpf',tipo='text',nome='CPF',valor='',largura='470',mascara='',site='1',ordenacao='3',obrigatorio='0'
						WHERE id_servico_campo='346';
--02/08/2010 09:07:20
UPDATE vsites_servico_campo SET campo='certidao_cnpj',tipo='text',nome='CNPJ',valor='',largura='470',mascara='',site='1',ordenacao='4',obrigatorio='0'
						WHERE id_servico_campo='260';
--02/08/2010 09:07:21
UPDATE vsites_servico_campo SET campo='certidao_endereco',tipo='text',nome='ENDERECO',valor='',largura='470',mascara='',site='1',ordenacao='5',obrigatorio='0'
						WHERE id_servico_campo='445';
--02/08/2010 09:07:22
UPDATE vsites_servico_campo SET campo='certidao_campo_cep',tipo='text',nome='CEP',valor='',largura='470',mascara='',site='1',ordenacao='6',obrigatorio='0'
						WHERE id_servico_campo='90';
--02/08/2010 09:07:23
UPDATE vsites_servico_campo SET campo='certidao_cidade',tipo='text',nome='CIDADE',valor='',largura='470',mascara='',site='1',ordenacao='7',obrigatorio='0'
						WHERE id_servico_campo='189';
--02/08/2010 09:07:24
UPDATE vsites_servico_campo SET campo='certidao_estado',tipo='text',nome='ESTADO',valor='',largura='470',mascara='',site='1',ordenacao='8',obrigatorio='0'
						WHERE id_servico_campo='553';
--02/08/2010 09:07:24
UPDATE vsites_servico_campo SET campo='certidao_cartorio',tipo='text',nome='CARTORIO',valor='',largura='470',mascara='',site='1',ordenacao='9',obrigatorio='0'
						WHERE id_servico_campo='74';
--02/08/2010 09:07:25
UPDATE vsites_servico_campo SET campo='certidao_subdistrito',tipo='text',nome='SUBDISTRITO',valor='',largura='470',mascara='',site='1',ordenacao='10',obrigatorio='0'
						WHERE id_servico_campo='1214';
--02/08/2010 09:07:26
UPDATE vsites_servico_campo SET campo='certidao_numero_contrato',tipo='text',nome='NUMERO DO CONTRATO',valor='',largura='470',mascara='',site='1',ordenacao='11',obrigatorio='0'
						WHERE id_servico_campo='837';
--02/08/2010 09:07:26
UPDATE vsites_servico_campo SET campo='certidao_matricula',tipo='text',nome='MATRICULA',valor='',largura='470',mascara='',site='1',ordenacao='12',obrigatorio='0'
						WHERE id_servico_campo='670';
--02/08/2010 09:07:27
UPDATE vsites_servico_campo SET campo='certidao_protocolo',tipo='text',nome='PROTOCOLO',valor='',largura='470',mascara='',site='0',ordenacao='13',obrigatorio='0'
						WHERE id_servico_campo='1024';
--02/08/2010 09:07:28
INSERT INTO vsites_servico_campo (id_servico, campo, nome, tipo, largura, site, ordenacao) VALUES ('80','certidao_finalidade','FINALIDADE','text','470','1','14');
--02/08/2010 09:07:28
DELETE FROM vsites_servico_campo WHERE id_servico_campo = '' AND id_servico='80';
--02/08/2010 09:07:36
UPDATE vsites_servico SET dias='', status='Ativo', descricao='Outros Serviços', site='1' WHERE id_servico='80';
--02/08/2010 09:07:37
UPDATE vsites_servico_campo SET campo='certidao_nome_proprietario',tipo='text',nome='NOME',valor='',largura='470',mascara='',site='1',ordenacao='1',obrigatorio='0'
						WHERE id_servico_campo='832';
--02/08/2010 09:07:37
UPDATE vsites_servico_campo SET campo='certidao_rg',tipo='text',nome='RG',valor='',largura='470',mascara='',site='1',ordenacao='2',obrigatorio='0'
						WHERE id_servico_campo='1200';
--02/08/2010 09:07:38
UPDATE vsites_servico_campo SET campo='certidao_cpf',tipo='text',nome='CPF',valor='',largura='470',mascara='',site='1',ordenacao='3',obrigatorio='0'
						WHERE id_servico_campo='346';
--02/08/2010 09:07:39
UPDATE vsites_servico_campo SET campo='certidao_cnpj',tipo='text',nome='CNPJ',valor='',largura='470',mascara='',site='1',ordenacao='4',obrigatorio='0'
						WHERE id_servico_campo='260';
--02/08/2010 09:07:40
UPDATE vsites_servico_campo SET campo='certidao_endereco',tipo='text',nome='ENDERECO',valor='',largura='470',mascara='',site='1',ordenacao='5',obrigatorio='0'
						WHERE id_servico_campo='445';
--02/08/2010 09:07:41
UPDATE vsites_servico_campo SET campo='certidao_campo_cep',tipo='text',nome='CEP',valor='',largura='470',mascara='',site='1',ordenacao='6',obrigatorio='0'
						WHERE id_servico_campo='90';
--02/08/2010 09:07:42
UPDATE vsites_servico_campo SET campo='certidao_cidade',tipo='text',nome='CIDADE',valor='',largura='470',mascara='',site='1',ordenacao='7',obrigatorio='0'
						WHERE id_servico_campo='189';
--02/08/2010 09:07:43
UPDATE vsites_servico_campo SET campo='certidao_estado',tipo='text',nome='ESTADO',valor='',largura='470',mascara='',site='1',ordenacao='8',obrigatorio='0'
						WHERE id_servico_campo='553';
--02/08/2010 09:07:44
UPDATE vsites_servico_campo SET campo='certidao_cartorio',tipo='text',nome='CARTORIO',valor='',largura='470',mascara='',site='1',ordenacao='9',obrigatorio='0'
						WHERE id_servico_campo='74';
--02/08/2010 09:07:46
UPDATE vsites_servico_campo SET campo='certidao_subdistrito',tipo='text',nome='SUBDISTRITO',valor='',largura='470',mascara='',site='1',ordenacao='10',obrigatorio='0'
						WHERE id_servico_campo='1214';
--02/08/2010 09:07:47
UPDATE vsites_servico_campo SET campo='certidao_numero_contrato',tipo='text',nome='NUMERO DO CONTRATO',valor='',largura='470',mascara='',site='1',ordenacao='11',obrigatorio='0'
						WHERE id_servico_campo='837';
--02/08/2010 09:07:48
UPDATE vsites_servico_campo SET campo='certidao_matricula',tipo='text',nome='MATRICULA',valor='',largura='470',mascara='',site='1',ordenacao='12',obrigatorio='0'
						WHERE id_servico_campo='670';
--02/08/2010 09:07:49
UPDATE vsites_servico_campo SET campo='certidao_protocolo',tipo='text',nome='PROTOCOLO',valor='',largura='470',mascara='',site='0',ordenacao='13',obrigatorio='0'
						WHERE id_servico_campo='1024';
--02/08/2010 09:07:50
INSERT INTO vsites_servico_campo (id_servico, campo, nome, tipo, largura, site, ordenacao) VALUES ('80','certidao_finalidade','FINALIDADE','text','470','1','14');
--02/08/2010 09:07:51
DELETE FROM vsites_servico_campo WHERE id_servico_campo = '' AND id_servico='80';
--02/08/2010 09:20:50
UPDATE vsites_servico SET dias='', status='Ativo', descricao='Outros Serviços', site='1' WHERE id_servico='80';
--02/08/2010 09:20:50
UPDATE vsites_servico_campo SET campo='certidao_nome_proprietario',tipo='text',nome='NOME',valor='',largura='470',mascara='',site='1',ordenacao='1',obrigatorio='0'
						WHERE id_servico_campo='832';
--02/08/2010 09:20:51
UPDATE vsites_servico_campo SET campo='certidao_rg',tipo='text',nome='RG',valor='',largura='470',mascara='',site='1',ordenacao='2',obrigatorio='0'
						WHERE id_servico_campo='1200';
--02/08/2010 09:20:51
UPDATE vsites_servico_campo SET campo='certidao_cpf',tipo='text',nome='CPF',valor='',largura='470',mascara='',site='1',ordenacao='3',obrigatorio='0'
						WHERE id_servico_campo='346';
--02/08/2010 09:20:52
UPDATE vsites_servico_campo SET campo='certidao_cnpj',tipo='text',nome='CNPJ',valor='',largura='470',mascara='',site='1',ordenacao='4',obrigatorio='0'
						WHERE id_servico_campo='260';
--02/08/2010 09:20:52
UPDATE vsites_servico_campo SET campo='certidao_endereco',tipo='text',nome='ENDERECO',valor='',largura='470',mascara='',site='1',ordenacao='5',obrigatorio='0'
						WHERE id_servico_campo='445';
--02/08/2010 09:20:53
UPDATE vsites_servico_campo SET campo='certidao_campo_cep',tipo='text',nome='CEP',valor='',largura='470',mascara='',site='1',ordenacao='6',obrigatorio='0'
						WHERE id_servico_campo='90';
--02/08/2010 09:20:53
UPDATE vsites_servico_campo SET campo='certidao_cidade',tipo='text',nome='CIDADE',valor='',largura='470',mascara='',site='1',ordenacao='7',obrigatorio='0'
						WHERE id_servico_campo='189';
--02/08/2010 09:20:54
UPDATE vsites_servico_campo SET campo='certidao_estado',tipo='text',nome='ESTADO',valor='',largura='470',mascara='',site='1',ordenacao='8',obrigatorio='0'
						WHERE id_servico_campo='553';
--02/08/2010 09:20:55
UPDATE vsites_servico_campo SET campo='certidao_cartorio',tipo='text',nome='CARTORIO',valor='',largura='470',mascara='',site='1',ordenacao='9',obrigatorio='0'
						WHERE id_servico_campo='74';
--02/08/2010 09:20:56
UPDATE vsites_servico_campo SET campo='certidao_subdistrito',tipo='text',nome='SUBDISTRITO',valor='',largura='470',mascara='',site='1',ordenacao='10',obrigatorio='0'
						WHERE id_servico_campo='1214';
--02/08/2010 09:20:57
UPDATE vsites_servico_campo SET campo='certidao_numero_contrato',tipo='text',nome='NUMERO DO CONTRATO',valor='',largura='470',mascara='',site='1',ordenacao='11',obrigatorio='0'
						WHERE id_servico_campo='837';
--02/08/2010 09:20:58
UPDATE vsites_servico_campo SET campo='certidao_matricula',tipo='text',nome='MATRICULA',valor='',largura='470',mascara='',site='1',ordenacao='12',obrigatorio='0'
						WHERE id_servico_campo='670';
--02/08/2010 09:20:59
UPDATE vsites_servico_campo SET campo='certidao_protocolo',tipo='text',nome='PROTOCOLO',valor='',largura='470',mascara='',site='0',ordenacao='13',obrigatorio='0'
						WHERE id_servico_campo='1024';
--02/08/2010 09:21:00
UPDATE vsites_servico_campo SET campo='certidao_finalidade',tipo='text',nome='FINALIDADE',valor='',largura='470',mascara='',site='1',ordenacao='14',obrigatorio='0'
						WHERE id_servico_campo='1630';
--02/08/2010 09:21:01
UPDATE vsites_servico_campo SET campo='certidao_finalidade',tipo='text',nome='FINALIDADE',valor='',largura='470',mascara='',site='1',ordenacao='15',obrigatorio='0'
						WHERE id_servico_campo='1631';
--02/08/2010 09:21:03
INSERT INTO vsites_servico_campo (id_servico, campo, nome, tipo, largura, site, ordenacao) VALUES ('80','certidao_tipo','TIPO DE CERTIDÃO','text','470','1','16');
--02/08/2010 09:21:03
DELETE FROM vsites_servico_campo WHERE id_servico_campo = '' AND id_servico='80';
--09/08/2010 16:39:17
UPDATE vsites_servico SET dias='', status='Inativo', descricao='Limpeza de Nome', site='1' WHERE id_servico='48';
--09/08/2010 16:39:17
UPDATE vsites_servico_campo SET campo='certidao_nome',tipo='text',nome='NOME',valor='',largura='470',mascara='',site='1',ordenacao='1',obrigatorio='1'
						WHERE id_servico_campo='783';
--09/08/2010 16:39:17
UPDATE vsites_servico_campo SET campo='certidao_rg',tipo='text',nome='RG',valor='',largura='470',mascara='',site='1',ordenacao='2',obrigatorio='0'
						WHERE id_servico_campo='1179';
--09/08/2010 16:39:17
UPDATE vsites_servico_campo SET campo='certidao_orgao_emissor',tipo='text',nome='ORGAO EMISSOR',valor='',largura='470',mascara='',site='1',ordenacao='3',obrigatorio='0'
						WHERE id_servico_campo='896';
--09/08/2010 16:39:17
UPDATE vsites_servico_campo SET campo='certidao_data_expedicao',tipo='text',nome='DATA DE EXPEDICAO',valor='',largura='470',mascara='',site='1',ordenacao='4',obrigatorio='0'
						WHERE id_servico_campo='378';
--09/08/2010 16:39:17
UPDATE vsites_servico_campo SET campo='certidao_cpf',tipo='text',nome='CPF',valor='',largura='470',mascara='',site='1',ordenacao='5',obrigatorio='0'
						WHERE id_servico_campo='326';
--09/08/2010 16:39:17
UPDATE vsites_servico_campo SET campo='certidao_cnpj',tipo='text',nome='CNPJ',valor='',largura='470',mascara='',site='1',ordenacao='6',obrigatorio='0'
						WHERE id_servico_campo='240';
--09/08/2010 16:39:17
UPDATE vsites_servico_campo SET campo='certidao_cidade',tipo='text',nome='CIDADE',valor='',largura='470',mascara='',site='1',ordenacao='7',obrigatorio='1'
						WHERE id_servico_campo='158';
--09/08/2010 16:39:17
UPDATE vsites_servico_campo SET campo='certidao_estado',tipo='text',nome='ESTADO',valor='',largura='470',mascara='',site='1',ordenacao='8',obrigatorio='1'
						WHERE id_servico_campo='523';
--09/08/2010 16:39:17
UPDATE vsites_servico_campo SET campo='certidao_cartorio',tipo='text',nome='CARTORIO',valor='',largura='470',mascara='',site='1',ordenacao='9',obrigatorio='0'
						WHERE id_servico_campo='50';
--09/08/2010 16:39:17
UPDATE vsites_servico_campo SET campo='certidao_protocolo',tipo='text',nome='PROTOCOLO',valor='',largura='470',mascara='',site='0',ordenacao='10',obrigatorio='0'
						WHERE id_servico_campo='997';
--09/08/2010 16:39:17
DELETE FROM vsites_servico_campo WHERE id_servico_campo = '' AND id_servico='48';
--13/09/2010 09:38:01
INSERT INTO vsites_servico (id_departamento, status, site, descricao) VALUES ('3','Inativo','','Validação de documentos');
--13/09/2010 09:38:01
INSERT INTO vsites_servico_campo (id_servico, campo, nome, tipo, largura, site, ordenacao) VALUES ('183','certidao_nome','NOME','text','470','0','1');
--13/09/2010 09:38:01
INSERT INTO vsites_servico_campo (id_servico, campo, nome, tipo, largura, site, ordenacao) VALUES ('183','certidao_endereco','ENDEREÇO','text','470','0','2');
--13/09/2010 09:38:01
INSERT INTO vsites_servico_campo (id_servico, campo, nome, tipo, largura, site, ordenacao) VALUES ('183','certidao_rg','RG','text','470','0','3');
--13/09/2010 09:38:01
INSERT INTO vsites_servico_campo (id_servico, campo, nome, tipo, largura, site, ordenacao) VALUES ('183','certidao_cpf','CPF','text','470','0','4');
--13/09/2010 09:38:01
INSERT INTO vsites_servico_campo (id_servico, campo, nome, tipo, largura, site, ordenacao) VALUES ('183','certidao_cnpj','CNPJ','text','470','0','5');
--13/09/2010 09:38:01
INSERT INTO vsites_servico_campo (id_servico, campo, nome, tipo, largura, site, ordenacao) VALUES ('183','certidao_pai','NOME DO PAI','text','470','0','6');
--13/09/2010 09:38:01
INSERT INTO vsites_servico_campo (id_servico, campo, nome, tipo, largura, site, ordenacao) VALUES ('183','certidao_mae','NOME DA MÃE','text','470','0','7');
--13/09/2010 09:38:01
INSERT INTO vsites_servico_campo (id_servico, campo, nome, tipo, largura, site, ordenacao) VALUES ('183','certidao_nacionalidade','PAÍS','text','470','0','8');
--13/09/2010 09:55:20
UPDATE vsites_servico SET dias='', status='Ativo', descricao='Validação de documentos', site='' WHERE id_servico='183';
--13/09/2010 09:55:20
UPDATE vsites_servico_campo SET campo='certidao_nome',tipo='text',nome='NOME',valor='',largura='470',mascara='',site='0',ordenacao='1',obrigatorio='0'
						WHERE id_servico_campo='1633';
--13/09/2010 09:55:20
UPDATE vsites_servico_campo SET campo='certidao_endereco',tipo='text',nome='ENDEREÇO',valor='',largura='470',mascara='',site='0',ordenacao='2',obrigatorio='0'
						WHERE id_servico_campo='1634';
--13/09/2010 09:55:20
UPDATE vsites_servico_campo SET campo='certidao_rg',tipo='text',nome='RG',valor='',largura='470',mascara='',site='0',ordenacao='3',obrigatorio='0'
						WHERE id_servico_campo='1635';
--13/09/2010 09:55:20
UPDATE vsites_servico_campo SET campo='certidao_cpf',tipo='text',nome='CPF',valor='',largura='470',mascara='',site='0',ordenacao='4',obrigatorio='0'
						WHERE id_servico_campo='1636';
--13/09/2010 09:55:20
UPDATE vsites_servico_campo SET campo='certidao_cnpj',tipo='text',nome='CNPJ',valor='',largura='470',mascara='',site='0',ordenacao='5',obrigatorio='0'
						WHERE id_servico_campo='1637';
--13/09/2010 09:55:20
UPDATE vsites_servico_campo SET campo='certidao_pai',tipo='text',nome='NOME DO PAI',valor='',largura='470',mascara='',site='0',ordenacao='6',obrigatorio='0'
						WHERE id_servico_campo='1638';
--13/09/2010 09:55:20
UPDATE vsites_servico_campo SET campo='certidao_mae',tipo='text',nome='NOME DA MÃE',valor='',largura='470',mascara='',site='0',ordenacao='7',obrigatorio='0'
						WHERE id_servico_campo='1639';
--13/09/2010 09:55:20
UPDATE vsites_servico_campo SET campo='certidao_nacionalidade',tipo='text',nome='PAÍS',valor='',largura='470',mascara='',site='0',ordenacao='8',obrigatorio='0'
						WHERE id_servico_campo='1640';
--13/09/2010 09:55:20
INSERT INTO vsites_servico_campo (id_servico, campo, nome, tipo, largura, site, ordenacao) VALUES ('183','certidao_banco_sacado','','text','470','0','9');
--13/09/2010 09:55:20
DELETE FROM vsites_servico_campo WHERE id_servico_campo = '' AND id_servico='183';
--13/09/2010 10:02:51
UPDATE vsites_servico SET dias='', status='Ativo', descricao='Validação de documentos', site='' WHERE id_servico='183';
--13/09/2010 10:02:52
UPDATE vsites_servico_campo SET campo='certidao_nome',tipo='text',nome='NOME',valor='',largura='470',mascara='',site='0',ordenacao='1',obrigatorio='0'
						WHERE id_servico_campo='1633';
--13/09/2010 10:02:52
UPDATE vsites_servico_campo SET campo='certidao_endereco',tipo='text',nome='ENDEREÇO',valor='',largura='470',mascara='',site='0',ordenacao='2',obrigatorio='0'
						WHERE id_servico_campo='1634';
--13/09/2010 10:02:53
UPDATE vsites_servico_campo SET campo='certidao_rg',tipo='text',nome='RG',valor='',largura='470',mascara='',site='0',ordenacao='3',obrigatorio='0'
						WHERE id_servico_campo='1635';
--13/09/2010 10:02:53
UPDATE vsites_servico_campo SET campo='certidao_cpf',tipo='text',nome='CPF',valor='',largura='470',mascara='',site='0',ordenacao='4',obrigatorio='0'
						WHERE id_servico_campo='1636';
--13/09/2010 10:02:53
UPDATE vsites_servico_campo SET campo='certidao_cnpj',tipo='text',nome='CNPJ',valor='',largura='470',mascara='',site='0',ordenacao='5',obrigatorio='0'
						WHERE id_servico_campo='1637';
--13/09/2010 10:02:54
UPDATE vsites_servico_campo SET campo='certidao_pai',tipo='text',nome='NOME DO PAI',valor='',largura='470',mascara='',site='0',ordenacao='6',obrigatorio='0'
						WHERE id_servico_campo='1638';
--13/09/2010 10:02:54
UPDATE vsites_servico_campo SET campo='certidao_mae',tipo='text',nome='NOME DA MÃE',valor='',largura='470',mascara='',site='0',ordenacao='7',obrigatorio='0'
						WHERE id_servico_campo='1639';
--13/09/2010 10:02:54
UPDATE vsites_servico_campo SET campo='certidao_nacionalidade',tipo='text',nome='PAÍS',valor='',largura='470',mascara='',site='0',ordenacao='8',obrigatorio='0'
						WHERE id_servico_campo='1640';
--13/09/2010 10:02:55
INSERT INTO vsites_servico_campo (id_servico, campo, nome, tipo, largura, site, ordenacao) VALUES ('183','certidao_cartorio','CARTÓRIO','text','470','0','9');
--13/09/2010 10:02:55
DELETE FROM vsites_servico_campo WHERE id_servico_campo = '' AND id_servico='183';
--13/09/2010 11:10:36
UPDATE vsites_servico SET dias='', status='Ativo', descricao='Validação de documentos', site='' WHERE id_servico='183';
--13/09/2010 11:10:36
UPDATE vsites_servico_campo SET campo='certidao_nome',tipo='text',nome='NOME',valor='',largura='470',mascara='',site='0',ordenacao='1',obrigatorio='0'
						WHERE id_servico_campo='1633';
--13/09/2010 11:10:36
UPDATE vsites_servico_campo SET campo='certidao_endereco',tipo='text',nome='ENDEREÇO',valor='',largura='470',mascara='',site='0',ordenacao='2',obrigatorio='0'
						WHERE id_servico_campo='1634';
--13/09/2010 11:10:36
UPDATE vsites_servico_campo SET campo='certidao_rg',tipo='text',nome='RG',valor='',largura='470',mascara='',site='0',ordenacao='3',obrigatorio='0'
						WHERE id_servico_campo='1635';
--13/09/2010 11:10:36
UPDATE vsites_servico_campo SET campo='certidao_cpf',tipo='text',nome='CPF',valor='',largura='470',mascara='',site='0',ordenacao='4',obrigatorio='0'
						WHERE id_servico_campo='1636';
--13/09/2010 11:10:37
UPDATE vsites_servico_campo SET campo='certidao_cnpj',tipo='text',nome='CNPJ',valor='',largura='470',mascara='',site='0',ordenacao='5',obrigatorio='0'
						WHERE id_servico_campo='1637';
--13/09/2010 11:10:37
INSERT INTO vsites_servico_campo (id_servico, campo, nome, tipo, largura, site, ordenacao) VALUES ('183','certidao_grau_parentesco','GRAU DE PARENTESCO','text','470','0','6');
--13/09/2010 11:10:37
UPDATE vsites_servico_campo SET campo='certidao_pai',tipo='text',nome='NOME DO PAI',valor='',largura='470',mascara='',site='0',ordenacao='7',obrigatorio='0'
						WHERE id_servico_campo='1638';
--13/09/2010 11:10:38
INSERT INTO vsites_servico_campo (id_servico, campo, nome, tipo, largura, site, ordenacao) VALUES ('183','certidao_pai_nascimento','NASCIMENTO DO PAI','text','470','0','8');
--13/09/2010 11:10:39
UPDATE vsites_servico_campo SET campo='certidao_mae',tipo='text',nome='NOME DA MÃE',valor='',largura='470',mascara='',site='0',ordenacao='9',obrigatorio='0'
						WHERE id_servico_campo='1639';
--13/09/2010 11:10:40
INSERT INTO vsites_servico_campo (id_servico, campo, nome, tipo, largura, site, ordenacao) VALUES ('183','certidao_mae_nascimento','NASCIMENTO DA MÃE','text','470','0','10');
--13/09/2010 11:10:40
UPDATE vsites_servico_campo SET campo='certidao_nacionalidade',tipo='text',nome='PAÍS',valor='',largura='470',mascara='',site='0',ordenacao='11',obrigatorio='0'
						WHERE id_servico_campo='1640';
--13/09/2010 11:10:41
UPDATE vsites_servico_campo SET campo='certidao_cartorio',tipo='text',nome='CARTÓRIO',valor='',largura='470',mascara='',site='0',ordenacao='12',obrigatorio='0'
						WHERE id_servico_campo='1642';
--13/09/2010 11:10:41
DELETE FROM vsites_servico_campo WHERE id_servico_campo = '' AND id_servico='183';
--29/09/2010 12:42:57
UPDATE vsites_servico SET dias='', status='Ativo', descricao='Aditivo de Contrato para Registro ou Alteração no Contrato', site='1' WHERE id_servico='37';
--29/09/2010 12:42:57
UPDATE vsites_servico_campo SET campo='certidao_nome',tipo='text',nome='NOME',valor='',largura='470',mascara='',site='1',ordenacao='1',obrigatorio='1'
						WHERE id_servico_campo='727';
--29/09/2010 12:42:57
UPDATE vsites_servico_campo SET campo='certidao_rg',tipo='text',nome='RG',valor='',largura='470',mascara='',site='1',ordenacao='2',obrigatorio='0'
						WHERE id_servico_campo='1135';
--29/09/2010 12:42:57
UPDATE vsites_servico_campo SET campo='certidao_cpf',tipo='text',nome='CPF',valor='',largura='470',mascara='',site='1',ordenacao='3',obrigatorio='0'
						WHERE id_servico_campo='284';
--29/09/2010 12:42:58
UPDATE vsites_servico_campo SET campo='certidao_cnpj',tipo='text',nome='CNPJ',valor='',largura='470',mascara='',site='1',ordenacao='4',obrigatorio='0'
						WHERE id_servico_campo='208';
--29/09/2010 12:42:58
UPDATE vsites_servico_campo SET campo='certidao_cidade',tipo='text',nome='CIDADE',valor='',largura='470',mascara='',site='1',ordenacao='5',obrigatorio='1'
						WHERE id_servico_campo='104';
--29/09/2010 12:42:58
UPDATE vsites_servico_campo SET campo='certidao_estado',tipo='text',nome='ESTADO',valor='',largura='470',mascara='',site='1',ordenacao='6',obrigatorio='1'
						WHERE id_servico_campo='470';
--29/09/2010 12:42:58
UPDATE vsites_servico_campo SET campo='certidao_cartorio',tipo='text',nome='CARTORIO',valor='',largura='470',mascara='',site='1',ordenacao='7',obrigatorio='1'
						WHERE id_servico_campo='24';
--29/09/2010 12:42:58
UPDATE vsites_servico_campo SET campo='certidao_n_contrato',tipo='text',nome='NUMERO DO CONTRATO',valor='',largura='470',mascara='',site='1',ordenacao='8',obrigatorio='1'
						WHERE id_servico_campo='849';
--29/09/2010 12:42:58
INSERT INTO vsites_servico_campo (id_servico, campo, nome, tipo, largura, site, ordenacao) VALUES ('37','certidao_valor','VALOR','text','470','1','9');
--29/09/2010 12:42:58
UPDATE vsites_servico_campo SET campo='certidao_protocolo',tipo='text',nome='PROTOCOLO',valor='',largura='470',mascara='',site='0',ordenacao='10',obrigatorio='0'
						WHERE id_servico_campo='958';
--29/09/2010 12:42:58
DELETE FROM vsites_servico_campo WHERE id_servico_campo = '' AND id_servico='37';
--29/09/2010 14:23:40
UPDATE vsites_servico SET dias='', status='Inativo', descricao='Limpeza de Nome', site='' WHERE id_servico='48';
--29/09/2010 14:23:40
UPDATE vsites_servico_campo SET campo='certidao_nome',tipo='text',nome='NOME',valor='',largura='470',mascara='',site='1',ordenacao='1',obrigatorio='1'
						WHERE id_servico_campo='783';
--29/09/2010 14:23:40
UPDATE vsites_servico_campo SET campo='certidao_rg',tipo='text',nome='RG',valor='',largura='470',mascara='',site='1',ordenacao='2',obrigatorio='0'
						WHERE id_servico_campo='1179';
--29/09/2010 14:23:40
UPDATE vsites_servico_campo SET campo='certidao_orgao_emissor',tipo='text',nome='ORGAO EMISSOR',valor='',largura='470',mascara='',site='1',ordenacao='3',obrigatorio='0'
						WHERE id_servico_campo='896';
--29/09/2010 14:23:40
UPDATE vsites_servico_campo SET campo='certidao_data_expedicao',tipo='text',nome='DATA DE EXPEDICAO',valor='',largura='470',mascara='',site='1',ordenacao='4',obrigatorio='0'
						WHERE id_servico_campo='378';
--29/09/2010 14:23:40
UPDATE vsites_servico_campo SET campo='certidao_cpf',tipo='text',nome='CPF',valor='',largura='470',mascara='',site='1',ordenacao='5',obrigatorio='0'
						WHERE id_servico_campo='326';
--29/09/2010 14:23:40
UPDATE vsites_servico_campo SET campo='certidao_cnpj',tipo='text',nome='CNPJ',valor='',largura='470',mascara='',site='1',ordenacao='6',obrigatorio='0'
						WHERE id_servico_campo='240';
--29/09/2010 14:23:40
UPDATE vsites_servico_campo SET campo='certidao_cidade',tipo='text',nome='CIDADE',valor='',largura='470',mascara='',site='1',ordenacao='7',obrigatorio='1'
						WHERE id_servico_campo='158';
--29/09/2010 14:23:40
UPDATE vsites_servico_campo SET campo='certidao_estado',tipo='text',nome='ESTADO',valor='',largura='470',mascara='',site='1',ordenacao='8',obrigatorio='1'
						WHERE id_servico_campo='523';
--29/09/2010 14:23:40
UPDATE vsites_servico_campo SET campo='certidao_cartorio',tipo='text',nome='CARTORIO',valor='',largura='470',mascara='',site='1',ordenacao='9',obrigatorio='0'
						WHERE id_servico_campo='50';
--29/09/2010 14:23:40
UPDATE vsites_servico_campo SET campo='certidao_protocolo',tipo='text',nome='PROTOCOLO',valor='',largura='470',mascara='',site='0',ordenacao='10',obrigatorio='0'
						WHERE id_servico_campo='997';
--29/09/2010 14:23:40
DELETE FROM vsites_servico_campo WHERE id_servico_campo = '' AND id_servico='48';
--29/09/2010 14:24:57
UPDATE vsites_servico SET dias='', status='Inativo', descricao='Limpeza de Nome', site='1' WHERE id_servico='48';
--29/09/2010 14:24:57
UPDATE vsites_servico_campo SET campo='certidao_nome',tipo='text',nome='NOME',valor='',largura='470',mascara='',site='1',ordenacao='1',obrigatorio='1'
						WHERE id_servico_campo='783';
--29/09/2010 14:24:57
UPDATE vsites_servico_campo SET campo='certidao_rg',tipo='text',nome='RG',valor='',largura='470',mascara='',site='1',ordenacao='2',obrigatorio='0'
						WHERE id_servico_campo='1179';
--29/09/2010 14:24:57
UPDATE vsites_servico_campo SET campo='certidao_orgao_emissor',tipo='text',nome='ORGAO EMISSOR',valor='',largura='470',mascara='',site='1',ordenacao='3',obrigatorio='0'
						WHERE id_servico_campo='896';
--29/09/2010 14:24:57
UPDATE vsites_servico_campo SET campo='certidao_data_expedicao',tipo='text',nome='DATA DE EXPEDICAO',valor='',largura='470',mascara='',site='1',ordenacao='4',obrigatorio='0'
						WHERE id_servico_campo='378';
--29/09/2010 14:24:57
UPDATE vsites_servico_campo SET campo='certidao_cpf',tipo='text',nome='CPF',valor='',largura='470',mascara='',site='1',ordenacao='5',obrigatorio='0'
						WHERE id_servico_campo='326';
--29/09/2010 14:24:57
UPDATE vsites_servico_campo SET campo='certidao_cnpj',tipo='text',nome='CNPJ',valor='',largura='470',mascara='',site='1',ordenacao='6',obrigatorio='0'
						WHERE id_servico_campo='240';
--29/09/2010 14:24:57
UPDATE vsites_servico_campo SET campo='certidao_cidade',tipo='text',nome='CIDADE',valor='',largura='470',mascara='',site='1',ordenacao='7',obrigatorio='1'
						WHERE id_servico_campo='158';
--29/09/2010 14:24:57
UPDATE vsites_servico_campo SET campo='certidao_estado',tipo='text',nome='ESTADO',valor='',largura='470',mascara='',site='1',ordenacao='8',obrigatorio='1'
						WHERE id_servico_campo='523';
--29/09/2010 14:24:57
UPDATE vsites_servico_campo SET campo='certidao_cartorio',tipo='text',nome='CARTORIO',valor='',largura='470',mascara='',site='1',ordenacao='9',obrigatorio='0'
						WHERE id_servico_campo='50';
--29/09/2010 14:24:57
UPDATE vsites_servico_campo SET campo='certidao_protocolo',tipo='text',nome='PROTOCOLO',valor='',largura='470',mascara='',site='0',ordenacao='10',obrigatorio='0'
						WHERE id_servico_campo='997';
--29/09/2010 14:24:57
DELETE FROM vsites_servico_campo WHERE id_servico_campo = '' AND id_servico='48';
--29/09/2010 14:26:30
UPDATE vsites_servico SET dias='', status='Inativo', descricao='Limpeza de Nome', site='1' WHERE id_servico='48';
--29/09/2010 14:26:30
UPDATE vsites_servico_campo SET campo='certidao_nome',tipo='text',nome='NOME',valor='',largura='470',mascara='',site='1',ordenacao='1',obrigatorio='1'
						WHERE id_servico_campo='783';
--29/09/2010 14:26:30
UPDATE vsites_servico_campo SET campo='certidao_rg',tipo='text',nome='RG',valor='',largura='470',mascara='',site='1',ordenacao='2',obrigatorio='0'
						WHERE id_servico_campo='1179';
--29/09/2010 14:26:30
UPDATE vsites_servico_campo SET campo='certidao_orgao_emissor',tipo='text',nome='ORGAO EMISSOR',valor='',largura='470',mascara='',site='1',ordenacao='3',obrigatorio='0'
						WHERE id_servico_campo='896';
--29/09/2010 14:26:30
UPDATE vsites_servico_campo SET campo='certidao_data_expedicao',tipo='text',nome='DATA DE EXPEDICAO',valor='',largura='470',mascara='',site='1',ordenacao='4',obrigatorio='0'
						WHERE id_servico_campo='378';
--29/09/2010 14:26:30
UPDATE vsites_servico_campo SET campo='certidao_cpf',tipo='text',nome='CPF',valor='',largura='470',mascara='',site='1',ordenacao='5',obrigatorio='0'
						WHERE id_servico_campo='326';
--29/09/2010 14:26:30
UPDATE vsites_servico_campo SET campo='certidao_cnpj',tipo='text',nome='CNPJ',valor='',largura='470',mascara='',site='1',ordenacao='6',obrigatorio='0'
						WHERE id_servico_campo='240';
--29/09/2010 14:26:30
UPDATE vsites_servico_campo SET campo='certidao_cidade',tipo='text',nome='CIDADE',valor='',largura='470',mascara='',site='1',ordenacao='7',obrigatorio='1'
						WHERE id_servico_campo='158';
--29/09/2010 14:26:30
UPDATE vsites_servico_campo SET campo='certidao_estado',tipo='text',nome='ESTADO',valor='',largura='470',mascara='',site='1',ordenacao='8',obrigatorio='1'
						WHERE id_servico_campo='523';
--29/09/2010 14:26:30
UPDATE vsites_servico_campo SET campo='certidao_cartorio',tipo='text',nome='CARTORIO',valor='',largura='470',mascara='',site='1',ordenacao='9',obrigatorio='0'
						WHERE id_servico_campo='50';
--29/09/2010 14:26:30
UPDATE vsites_servico_campo SET campo='certidao_protocolo',tipo='text',nome='PROTOCOLO',valor='',largura='470',mascara='',site='0',ordenacao='10',obrigatorio='0'
						WHERE id_servico_campo='997';
--29/09/2010 14:26:31
DELETE FROM vsites_servico_campo WHERE id_servico_campo = '' AND id_servico='48';
--30/11/2010 16:10:32
UPDATE vsites_servico SET dias='', status='Ativo', descricao='Limpeza de Nome', site='1' WHERE id_servico='48';
--30/11/2010 16:10:32
UPDATE vsites_servico_campo SET campo='certidao_nome',tipo='text',nome='NOME',valor='',largura='470',mascara='',site='1',ordenacao='1',obrigatorio='1'
						WHERE id_servico_campo='783';
--30/11/2010 16:10:32
UPDATE vsites_servico_campo SET campo='certidao_rg',tipo='text',nome='RG',valor='',largura='470',mascara='',site='1',ordenacao='2',obrigatorio='0'
						WHERE id_servico_campo='1179';
--30/11/2010 16:10:32
UPDATE vsites_servico_campo SET campo='certidao_orgao_emissor',tipo='text',nome='ORGAO EMISSOR',valor='',largura='470',mascara='',site='1',ordenacao='3',obrigatorio='0'
						WHERE id_servico_campo='896';
--30/11/2010 16:10:32
UPDATE vsites_servico_campo SET campo='certidao_data_expedicao',tipo='text',nome='DATA DE EXPEDICAO',valor='',largura='470',mascara='',site='1',ordenacao='4',obrigatorio='0'
						WHERE id_servico_campo='378';
--30/11/2010 16:10:32
UPDATE vsites_servico_campo SET campo='certidao_cpf',tipo='text',nome='CPF',valor='',largura='470',mascara='',site='1',ordenacao='5',obrigatorio='0'
						WHERE id_servico_campo='326';
--30/11/2010 16:10:32
UPDATE vsites_servico_campo SET campo='certidao_cnpj',tipo='text',nome='CNPJ',valor='',largura='470',mascara='',site='1',ordenacao='6',obrigatorio='0'
						WHERE id_servico_campo='240';
--30/11/2010 16:10:32
UPDATE vsites_servico_campo SET campo='certidao_estado',tipo='text',nome='ESTADO',valor='',largura='470',mascara='',site='1',ordenacao='7',obrigatorio='1'
						WHERE id_servico_campo='523';
--30/11/2010 16:10:32
UPDATE vsites_servico_campo SET campo='certidao_cidade',tipo='text',nome='CIDADE',valor='',largura='470',mascara='',site='1',ordenacao='8',obrigatorio='1'
						WHERE id_servico_campo='158';
--30/11/2010 16:10:32
UPDATE vsites_servico_campo SET campo='certidao_cartorio',tipo='text',nome='CARTORIO',valor='',largura='470',mascara='',site='1',ordenacao='9',obrigatorio='0'
						WHERE id_servico_campo='50';
--30/11/2010 16:10:32
UPDATE vsites_servico_campo SET campo='certidao_protocolo',tipo='text',nome='PROTOCOLO',valor='',largura='470',mascara='',site='0',ordenacao='10',obrigatorio='0'
						WHERE id_servico_campo='997';
--30/11/2010 16:10:32
DELETE FROM vsites_servico_campo WHERE id_servico_campo = '' AND id_servico='48';
--30/11/2010 16:12:11
UPDATE vsites_servico SET dias='', status='Ativo', descricao='Limpeza de Nome', site='1' WHERE id_servico='48';
--30/11/2010 16:12:11
UPDATE vsites_servico_campo SET campo='certidao_nome',tipo='text',nome='NOME',valor='',largura='470',mascara='',site='1',ordenacao='1',obrigatorio='1'
						WHERE id_servico_campo='783';
--30/11/2010 16:12:11
UPDATE vsites_servico_campo SET campo='certidao_rg',tipo='text',nome='RG',valor='',largura='470',mascara='',site='1',ordenacao='2',obrigatorio='0'
						WHERE id_servico_campo='1179';
--30/11/2010 16:12:11
UPDATE vsites_servico_campo SET campo='certidao_orgao_emissor',tipo='text',nome='ORGAO EMISSOR',valor='',largura='470',mascara='',site='1',ordenacao='3',obrigatorio='0'
						WHERE id_servico_campo='896';
--30/11/2010 16:12:11
UPDATE vsites_servico_campo SET campo='certidao_data_expedicao',tipo='text',nome='DATA DE EXPEDICAO',valor='',largura='470',mascara='',site='1',ordenacao='4',obrigatorio='0'
						WHERE id_servico_campo='378';
--30/11/2010 16:12:11
UPDATE vsites_servico_campo SET campo='certidao_cpf',tipo='text',nome='CPF',valor='',largura='470',mascara='',site='1',ordenacao='5',obrigatorio='0'
						WHERE id_servico_campo='326';
--30/11/2010 16:12:11
UPDATE vsites_servico_campo SET campo='certidao_cnpj',tipo='text',nome='CNPJ',valor='',largura='470',mascara='',site='1',ordenacao='6',obrigatorio='0'
						WHERE id_servico_campo='240';
--30/11/2010 16:12:11
UPDATE vsites_servico_campo SET campo='certidao_estado',tipo='text',nome='ESTADO',valor='',largura='470',mascara='',site='1',ordenacao='7',obrigatorio='1'
						WHERE id_servico_campo='523';
--30/11/2010 16:12:11
UPDATE vsites_servico_campo SET campo='certidao_cidade',tipo='text',nome='CIDADE',valor='',largura='470',mascara='',site='1',ordenacao='8',obrigatorio='1'
						WHERE id_servico_campo='158';
--30/11/2010 16:12:11
UPDATE vsites_servico_campo SET campo='certidao_cartorio',tipo='text',nome='CARTORIO',valor='',largura='470',mascara='',site='1',ordenacao='9',obrigatorio='0'
						WHERE id_servico_campo='50';
--30/11/2010 16:12:11
UPDATE vsites_servico_campo SET campo='certidao_protocolo',tipo='text',nome='PROTOCOLO',valor='',largura='470',mascara='',site='0',ordenacao='10',obrigatorio='0'
						WHERE id_servico_campo='997';
--30/11/2010 16:12:11
DELETE FROM vsites_servico_campo WHERE id_servico_campo = '' AND id_servico='48';
--03/12/2010 14:42:41
UPDATE vsites_servico SET dias='', status='Ativo', descricao='Pesquisa de Imóveis - Através de Busca Verbal (Declaração de Nada Consta)', site='1' WHERE id_servico='169';
--03/12/2010 14:42:42
UPDATE vsites_servico_campo SET campo='certidao_cartorio',tipo='text',nome='CARTÓRIO',valor='',largura='470',mascara='',site='1',ordenacao='1',obrigatorio='1'
						WHERE id_servico_campo='1435';
--03/12/2010 14:42:42
UPDATE vsites_servico_campo SET campo='certidao_nome_proprietario',tipo='text',nome='NOME',valor='',largura='470',mascara='',site='1',ordenacao='2',obrigatorio='1'
						WHERE id_servico_campo='1436';
--03/12/2010 14:42:42
UPDATE vsites_servico_campo SET campo='certidao_cpf',tipo='text',nome='CPF',valor='',largura='470',mascara='',site='1',ordenacao='3',obrigatorio='0'
						WHERE id_servico_campo='1437';
--03/12/2010 14:42:42
UPDATE vsites_servico_campo SET campo='certidao_cnpj',tipo='text',nome='CNPJ',valor='',largura='470',mascara='',site='1',ordenacao='4',obrigatorio='0'
						WHERE id_servico_campo='1438';
--03/12/2010 14:42:42
UPDATE vsites_servico_campo SET campo='certidao_estado',tipo='text',nome='UF',valor='',largura='470',mascara='',site='1',ordenacao='5',obrigatorio='1'
						WHERE id_servico_campo='1440';
--03/12/2010 14:42:42
UPDATE vsites_servico_campo SET campo='certidao_cidade',tipo='text',nome='CIDADE',valor='',largura='470',mascara='',site='1',ordenacao='6',obrigatorio='1'
						WHERE id_servico_campo='1439';
--03/12/2010 14:42:42
DELETE FROM vsites_servico_campo WHERE id_servico_campo = '' AND id_servico='169';
--03/12/2010 14:44:44
UPDATE vsites_servico SET dias='', status='Ativo', descricao='Pesquisa de Imóveis - Através de Busca Verbal (Declaração de Nada Consta)', site='1' WHERE id_servico='169';
--03/12/2010 14:44:44
UPDATE vsites_servico_campo SET campo='certidao_cartorio',tipo='text',nome='CARTÓRIO',valor='',largura='470',mascara='',site='1',ordenacao='1',obrigatorio='1'
						WHERE id_servico_campo='1435';
--03/12/2010 14:44:44
UPDATE vsites_servico_campo SET campo='certidao_nome_proprietario',tipo='text',nome='NOME',valor='',largura='470',mascara='',site='1',ordenacao='2',obrigatorio='1'
						WHERE id_servico_campo='1436';
--03/12/2010 14:44:44
UPDATE vsites_servico_campo SET campo='certidao_cpf',tipo='text',nome='CPF',valor='',largura='470',mascara='',site='1',ordenacao='3',obrigatorio='0'
						WHERE id_servico_campo='1437';
--03/12/2010 14:44:45
UPDATE vsites_servico_campo SET campo='certidao_cnpj',tipo='text',nome='CNPJ',valor='',largura='470',mascara='',site='1',ordenacao='4',obrigatorio='0'
						WHERE id_servico_campo='1438';
--03/12/2010 14:44:45
UPDATE vsites_servico_campo SET campo='certidao_estado',tipo='text',nome='UF',valor='',largura='470',mascara='',site='1',ordenacao='5',obrigatorio='1'
						WHERE id_servico_campo='1440';
--03/12/2010 14:44:45
UPDATE vsites_servico_campo SET campo='certidao_cidade',tipo='text',nome='CIDADE',valor='',largura='470',mascara='',site='1',ordenacao='6',obrigatorio='1'
						WHERE id_servico_campo='1439';
--03/12/2010 14:44:45
DELETE FROM vsites_servico_campo WHERE id_servico_campo = '' AND id_servico='169';
--03/12/2010 14:45:52
UPDATE vsites_servico SET dias='', status='Ativo', descricao='Pesquisa de Imóveis - Através de Certidões', site='1' WHERE id_servico='170';
--03/12/2010 14:45:52
UPDATE vsites_servico_campo SET campo='certidao_cartorio',tipo='text',nome='CARTÓRIO',valor='',largura='470',mascara='',site='1',ordenacao='1',obrigatorio='1'
						WHERE id_servico_campo='1441';
--03/12/2010 14:45:52
UPDATE vsites_servico_campo SET campo='certidao_nome_proprietario',tipo='text',nome='NOME',valor='',largura='470',mascara='',site='1',ordenacao='2',obrigatorio='1'
						WHERE id_servico_campo='1442';
--03/12/2010 14:45:52
UPDATE vsites_servico_campo SET campo='certidao_cpf',tipo='text',nome='CPF',valor='',largura='470',mascara='',site='1',ordenacao='3',obrigatorio='0'
						WHERE id_servico_campo='1443';
--03/12/2010 14:45:52
UPDATE vsites_servico_campo SET campo='certidao_cnpj',tipo='text',nome='CNPJ',valor='',largura='470',mascara='',site='1',ordenacao='4',obrigatorio='0'
						WHERE id_servico_campo='1444';
--03/12/2010 14:45:52
UPDATE vsites_servico_campo SET campo='certidao_estado',tipo='text',nome='UF',valor='',largura='470',mascara='',site='1',ordenacao='5',obrigatorio='1'
						WHERE id_servico_campo='1446';
--03/12/2010 14:45:52
UPDATE vsites_servico_campo SET campo='certidao_cidade',tipo='text',nome='CIDADE',valor='',largura='470',mascara='',site='1',ordenacao='6',obrigatorio='1'
						WHERE id_servico_campo='1445';
--03/12/2010 14:45:52
DELETE FROM vsites_servico_campo WHERE id_servico_campo = '' AND id_servico='170';
--08/12/2010 10:02:43
INSERT INTO vsites_servico (id_departamento, status, site, descricao) VALUES ('4','Inativo','','Localização de inadimplente de Crédito Imobiliário');
--08/12/2010 10:02:43
INSERT INTO vsites_servico_campo (id_servico, campo, nome, tipo, largura, site, ordenacao) VALUES ('184','certidao_nome','NOME DO DEVEDOR','text','470','0','1');
--08/12/2010 10:02:43
INSERT INTO vsites_servico_campo (id_servico, campo, nome, tipo, largura, site, ordenacao) VALUES ('184','certidao_n_contrato','NÚMERO DO CONTRATO','text','470','0','2');
--08/12/2010 10:02:43
INSERT INTO vsites_servico_campo (id_servico, campo, nome, tipo, largura, site, ordenacao) VALUES ('184','certidao_rg','RG','text','470','0','3');
--08/12/2010 10:02:43
INSERT INTO vsites_servico_campo (id_servico, campo, nome, tipo, largura, site, ordenacao) VALUES ('184','certidao_cpf','CPF','text','470','0','4');
--08/12/2010 10:02:43
INSERT INTO vsites_servico_campo (id_servico, campo, nome, tipo, largura, site, ordenacao) VALUES ('184','certidao_endereco_imovel','ENDEREÇO DO IMÓVEL','text','470','0','5');
--08/12/2010 10:02:43
INSERT INTO vsites_servico_campo (id_servico, campo, nome, tipo, largura, site, ordenacao) VALUES ('184','certidao_registro','REGISTRO DE IMÓVEL','text','470','0','6');
--08/12/2010 10:02:43
INSERT INTO vsites_servico_campo (id_servico, campo, nome, tipo, largura, site, ordenacao) VALUES ('184','certidao_endereco','ENDEREÇO DE CORRESPONDÊNCIA','text','470','0','7');
--08/12/2010 10:02:43
INSERT INTO vsites_servico_campo (id_servico, campo, nome, tipo, largura, site, ordenacao) VALUES ('184','c_endereco','ÚLTIMO ENDEREÇO DEVEDOR','text','470','0','8');
--08/12/2010 10:02:43
INSERT INTO vsites_servico_campo (id_servico, campo, nome, tipo, largura, site, ordenacao) VALUES ('184','certidao_tipo_processo','TIPO DE NOTIFICAÇÃO','text','470','0','9');
--08/12/2010 11:11:34
UPDATE vsites_servico SET dias='', status='Ativo', descricao='Localização de inadimplente de Crédito Imobiliário', site='' WHERE id_servico='184';
--08/12/2010 11:11:34
UPDATE vsites_servico_campo SET campo='certidao_nome',tipo='text',nome='NOME DO DEVEDOR',valor='',largura='470',mascara='',site='0',ordenacao='1',obrigatorio='0'
						WHERE id_servico_campo='1647';
--08/12/2010 11:11:34
UPDATE vsites_servico_campo SET campo='certidao_n_contrato',tipo='text',nome='NÚMERO DO CONTRATO',valor='',largura='470',mascara='',site='0',ordenacao='2',obrigatorio='0'
						WHERE id_servico_campo='1648';
--08/12/2010 11:11:34
UPDATE vsites_servico_campo SET campo='certidao_rg',tipo='text',nome='RG',valor='',largura='470',mascara='',site='0',ordenacao='3',obrigatorio='0'
						WHERE id_servico_campo='1649';
--08/12/2010 11:11:34
UPDATE vsites_servico_campo SET campo='certidao_cpf',tipo='text',nome='CPF',valor='',largura='470',mascara='',site='0',ordenacao='4',obrigatorio='0'
						WHERE id_servico_campo='1650';
--08/12/2010 11:11:34
UPDATE vsites_servico_campo SET campo='certidao_endereco_imovel',tipo='text',nome='ENDEREÇO DO IMÓVEL',valor='',largura='470',mascara='',site='0',ordenacao='5',obrigatorio='0'
						WHERE id_servico_campo='1651';
--08/12/2010 11:11:34
UPDATE vsites_servico_campo SET campo='certidao_registro',tipo='text',nome='REGISTRO DE IMÓVEL',valor='',largura='470',mascara='',site='0',ordenacao='6',obrigatorio='0'
						WHERE id_servico_campo='1652';
--08/12/2010 11:11:34
UPDATE vsites_servico_campo SET campo='certidao_endereco',tipo='text',nome='ENDEREÇO DE CORRESPONDÊNCIA',valor='',largura='470',mascara='',site='0',ordenacao='7',obrigatorio='0'
						WHERE id_servico_campo='1653';
--08/12/2010 11:11:34
UPDATE vsites_servico_campo SET campo='c_endereco',tipo='text',nome='ÚLTIMO ENDEREÇO DEVEDOR',valor='',largura='470',mascara='',site='0',ordenacao='8',obrigatorio='0'
						WHERE id_servico_campo='1654';
--08/12/2010 11:11:34
UPDATE vsites_servico_campo SET campo='certidao_tipo_processo',tipo='text',nome='TIPO DE NOTIFICAÇÃO',valor='',largura='470',mascara='',site='0',ordenacao='9',obrigatorio='0'
						WHERE id_servico_campo='1655';
--08/12/2010 11:11:34
DELETE FROM vsites_servico_campo WHERE id_servico_campo = '' AND id_servico='184';
--08/12/2010 11:19:26
INSERT INTO vsites_servico (id_departamento, status, site, descricao) VALUES ('4','Inativo','','emitir certidão negativa de naturalização');
--08/12/2010 12:39:22
INSERT INTO vsites_servico (id_departamento, status, site, descricao) VALUES ('4','Inativo','','Emitir certidão negativa de naturalização');
--08/12/2010 12:39:22
INSERT INTO vsites_servico_campo (id_servico, campo, nome, tipo, largura, site, ordenacao) VALUES ('186','certidao_responsavel','NOME INTERESSADO','text','470','0','1');
--08/12/2010 12:39:22
INSERT INTO vsites_servico_campo (id_servico, campo, nome, tipo, largura, site, ordenacao) VALUES ('186','certidao_grau_parentesco','GRAU DE PARENTESCO','text','470','0','2');
--08/12/2010 12:39:22
INSERT INTO vsites_servico_campo (id_servico, campo, nome, tipo, largura, site, ordenacao) VALUES ('186','certidao_nome','NOME','text','470','0','3');
--08/12/2010 12:39:22
INSERT INTO vsites_servico_campo (id_servico, campo, nome, tipo, largura, site, ordenacao) VALUES ('186','certidao_pai','PAI','text','470','0','4');
--08/12/2010 12:39:22
INSERT INTO vsites_servico_campo (id_servico, campo, nome, tipo, largura, site, ordenacao) VALUES ('186','certidao_mae','MAE','text','470','0','5');
--08/12/2010 12:39:22
INSERT INTO vsites_servico_campo (id_servico, campo, nome, tipo, largura, site, ordenacao) VALUES ('186','certidao_data_nascimento','DATA DE NASCIMENTO','text','470','0','6');
--08/12/2010 12:39:22
INSERT INTO vsites_servico_campo (id_servico, campo, nome, tipo, largura, site, ordenacao) VALUES ('186','certidao_nacionalidade','PAÍS NASCIMENTO','text','470','0','7');
--08/12/2010 12:42:57
UPDATE vsites_servico SET dias='', status='Inativo', descricao='Emitir certidão negativa de naturalização', site='' WHERE id_servico='185';
--08/12/2010 12:42:57
INSERT INTO vsites_servico_campo (id_servico, campo, nome, tipo, largura, site, ordenacao) VALUES ('185','certidao_nome','NOME','text','470','0','1');
--08/12/2010 12:42:57
INSERT INTO vsites_servico_campo (id_servico, campo, nome, tipo, largura, site, ordenacao) VALUES ('185','certidao_pai','PAI','text','470','0','2');
--08/12/2010 12:42:57
INSERT INTO vsites_servico_campo (id_servico, campo, nome, tipo, largura, site, ordenacao) VALUES ('185','certidao_mae','MÃE','text','470','0','3');
--08/12/2010 12:42:57
INSERT INTO vsites_servico_campo (id_servico, campo, nome, tipo, largura, site, ordenacao) VALUES ('185','certidao_data_nascimento','DATA NASCIMENTO','text','470','0','4');
--08/12/2010 12:42:57
DELETE FROM vsites_servico_campo WHERE id_servico_campo = '' AND id_servico='185';
--08/12/2010 12:47:23
UPDATE vsites_servico SET dias='', status='Inativo', descricao='Emitir certidão negativa de naturalização', site='' WHERE id_servico='185';
--08/12/2010 12:47:24
UPDATE vsites_servico_campo SET campo='certidao_nome',tipo='text',nome='NOME',valor='',largura='470',mascara='',site='0',ordenacao='1',obrigatorio='0'
						WHERE id_servico_campo='1663';
--08/12/2010 12:47:24
UPDATE vsites_servico_campo SET campo='certidao_pai',tipo='text',nome='PAI',valor='',largura='470',mascara='',site='0',ordenacao='2',obrigatorio='0'
						WHERE id_servico_campo='1664';
--08/12/2010 12:47:24
UPDATE vsites_servico_campo SET campo='certidao_mae',tipo='text',nome='MÃE',valor='',largura='470',mascara='',site='0',ordenacao='3',obrigatorio='0'
						WHERE id_servico_campo='1665';
--08/12/2010 12:47:24
UPDATE vsites_servico_campo SET campo='certidao_data_nascimento',tipo='text',nome='DATA NASCIMENTO',valor='',largura='470',mascara='',site='0',ordenacao='4',obrigatorio='0'
						WHERE id_servico_campo='1666';
--08/12/2010 12:47:24
INSERT INTO vsites_servico_campo (id_servico, campo, nome, tipo, largura, site, ordenacao) VALUES ('185','certidao_nacionalidade','PAIS DE NASCIMENTO','text','470','0','5');
--08/12/2010 12:47:25
DELETE FROM vsites_servico_campo WHERE id_servico_campo = '' AND id_servico='185';
--08/12/2010 12:50:44
UPDATE vsites_servico SET dias='', status='Inativo', descricao='Emitir certidão negativa de naturalização', site='' WHERE id_servico='185';
--08/12/2010 12:50:44
INSERT INTO vsites_servico_campo (id_servico, campo, nome, tipo, largura, site, ordenacao) VALUES ('185','certidao_nome_proprietario','NOME INTERESSADO','text','470','0','1');
--08/12/2010 12:50:44
INSERT INTO vsites_servico_campo (id_servico, campo, nome, tipo, largura, site, ordenacao) VALUES ('185','certidao_grau_parentesco','GRAU DE PARENTESCO','text','470','0','2');
--08/12/2010 12:50:44
INSERT INTO vsites_servico_campo (id_servico, campo, nome, tipo, largura, site, ordenacao) VALUES ('185','certidao_finalidade','MOTIVO DA SOLICITAÇÃO','text','470','0','3');
--08/12/2010 12:50:44
UPDATE vsites_servico_campo SET campo='certidao_nome',tipo='text',nome='NOME',valor='',largura='470',mascara='',site='0',ordenacao='4',obrigatorio='0'
						WHERE id_servico_campo='1663';
--08/12/2010 12:50:44
UPDATE vsites_servico_campo SET campo='certidao_pai',tipo='text',nome='PAI',valor='',largura='470',mascara='',site='0',ordenacao='5',obrigatorio='0'
						WHERE id_servico_campo='1664';
--08/12/2010 12:50:44
UPDATE vsites_servico_campo SET campo='certidao_mae',tipo='text',nome='MÃE',valor='',largura='470',mascara='',site='0',ordenacao='6',obrigatorio='0'
						WHERE id_servico_campo='1665';
--08/12/2010 12:50:44
UPDATE vsites_servico_campo SET campo='certidao_data_nascimento',tipo='text',nome='DATA NASCIMENTO',valor='',largura='470',mascara='',site='0',ordenacao='7',obrigatorio='0'
						WHERE id_servico_campo='1666';
--08/12/2010 12:50:44
UPDATE vsites_servico_campo SET campo='certidao_nacionalidade',tipo='text',nome='PAÍS DE NASCIMENTO',valor='',largura='470',mascara='',site='0',ordenacao='8',obrigatorio='0'
						WHERE id_servico_campo='1667';
--08/12/2010 12:50:44
DELETE FROM vsites_servico_campo WHERE id_servico_campo = '' AND id_servico='185';
--04/02/2011 11:17:38
INSERT INTO vsites_servico (id_departamento, status, site, descricao) VALUES ('4','Ativo','','Localização de Pessoas');
--04/02/2011 11:17:38
INSERT INTO vsites_servico_campo (id_servico, campo, nome, tipo, largura, site, ordenacao) VALUES ('187','certidao_nome','NOME','text','470','0','1');
--04/02/2011 11:17:38
INSERT INTO vsites_servico_campo (id_servico, campo, nome, tipo, largura, site, ordenacao) VALUES ('187','certidao_rg','RG','text','470','0','2');
--04/02/2011 11:17:38
INSERT INTO vsites_servico_campo (id_servico, campo, nome, tipo, largura, site, ordenacao) VALUES ('187','certidao_cpf','CPF','text','470','0','3');
--04/02/2011 11:17:38
INSERT INTO vsites_servico_campo (id_servico, campo, nome, tipo, largura, site, ordenacao) VALUES ('187','certidao_cnpj','CNPJ','text','470','0','4');
--04/02/2011 11:33:37
UPDATE vsites_servico SET dias='', status='Ativo', descricao='Localização de Pessoas', site='1' WHERE id_servico='187';
--04/02/2011 11:33:37
UPDATE vsites_servico_campo SET campo='certidao_nome',tipo='text',nome='NOME',valor='',largura='470',mascara='',site='0',ordenacao='1',obrigatorio='0'
						WHERE id_servico_campo='1671';
--04/02/2011 11:33:37
UPDATE vsites_servico_campo SET campo='certidao_rg',tipo='text',nome='RG',valor='',largura='470',mascara='',site='0',ordenacao='2',obrigatorio='0'
						WHERE id_servico_campo='1672';
--04/02/2011 11:33:37
UPDATE vsites_servico_campo SET campo='certidao_cpf',tipo='text',nome='CPF',valor='',largura='470',mascara='',site='0',ordenacao='3',obrigatorio='0'
						WHERE id_servico_campo='1673';
--04/02/2011 11:33:37
UPDATE vsites_servico_campo SET campo='certidao_cnpj',tipo='text',nome='CNPJ',valor='',largura='470',mascara='',site='0',ordenacao='4',obrigatorio='0'
						WHERE id_servico_campo='1674';
--04/02/2011 11:33:37
DELETE FROM vsites_servico_campo WHERE id_servico_campo = '' AND id_servico='187';
--14/03/2011 15:18:21
UPDATE vsites_servico SET dias='', status='Ativo', descricao='Negativa de Protesto', site='1' WHERE id_servico='5';
--14/03/2011 15:18:21
UPDATE vsites_servico_campo SET campo='certidao_nome',tipo='text',nome='NOME',valor='',largura='470',mascara='',site='1',ordenacao='1',obrigatorio='1'
						WHERE id_servico_campo='787';
--14/03/2011 15:18:21
UPDATE vsites_servico_campo SET campo='certidao_rg',tipo='text',nome='RG',valor='',largura='470',mascara='',site='1',ordenacao='2',obrigatorio='0'
						WHERE id_servico_campo='1184';
--14/03/2011 15:18:21
UPDATE vsites_servico_campo SET campo='certidao_cpf',tipo='text',nome='CPF',valor='',largura='470',mascara='',site='1',ordenacao='3',obrigatorio='0'
						WHERE id_servico_campo='329';
--14/03/2011 15:18:21
UPDATE vsites_servico_campo SET campo='certidao_cnpj',tipo='text',nome='CNPJ',valor='',largura='470',mascara='',site='1',ordenacao='4',obrigatorio='0'
						WHERE id_servico_campo='243';
--14/03/2011 15:18:21
UPDATE vsites_servico_campo SET campo='certidao_estado',tipo='text',nome='ESTADO',valor='',largura='470',mascara='',site='1',ordenacao='5',obrigatorio='1'
						WHERE id_servico_campo='529';
--14/03/2011 15:18:21
UPDATE vsites_servico_campo SET campo='certidao_cidade',tipo='text',nome='CIDADE',valor='',largura='470',mascara='',site='1',ordenacao='6',obrigatorio='1'
						WHERE id_servico_campo='165';
--14/03/2011 15:18:21
UPDATE vsites_servico_campo SET campo='certidao_cartorio',tipo='text',nome='CARTORIO',valor='',largura='470',mascara='',site='1',ordenacao='7',obrigatorio='0'
						WHERE id_servico_campo='56';
--14/03/2011 15:18:21
UPDATE vsites_servico_campo SET campo='certidao_qtdd_cartorio',tipo='text',nome='NUMERO DO CARTORIO',valor='',largura='470',mascara='',site='1',ordenacao='8',obrigatorio='1'
						WHERE id_servico_campo='1596';
--14/03/2011 15:18:21
INSERT INTO vsites_servico_campo (id_servico, campo, nome, tipo, largura, site, ordenacao) VALUES ('5','certidao_comarca_forum','COMARCA','text','470','1','9');
--14/03/2011 15:18:21
DELETE FROM vsites_servico_campo WHERE id_servico_campo = '' AND id_servico='5';
--14/03/2011 15:19:22
UPDATE vsites_servico SET dias='', status='Ativo', descricao='Negativa de Protesto', site='1' WHERE id_servico='5';
--14/03/2011 15:19:22
UPDATE vsites_servico_campo SET campo='certidao_nome',tipo='text',nome='NOME',valor='',largura='470',mascara='',site='1',ordenacao='1',obrigatorio='1'
						WHERE id_servico_campo='787';
--14/03/2011 15:19:22
UPDATE vsites_servico_campo SET campo='certidao_rg',tipo='text',nome='RG',valor='',largura='470',mascara='',site='1',ordenacao='2',obrigatorio='0'
						WHERE id_servico_campo='1184';
--14/03/2011 15:19:22
UPDATE vsites_servico_campo SET campo='certidao_cpf',tipo='text',nome='CPF',valor='',largura='470',mascara='',site='1',ordenacao='3',obrigatorio='0'
						WHERE id_servico_campo='329';
--14/03/2011 15:19:22
UPDATE vsites_servico_campo SET campo='certidao_cnpj',tipo='text',nome='CNPJ',valor='',largura='470',mascara='',site='1',ordenacao='4',obrigatorio='0'
						WHERE id_servico_campo='243';
--14/03/2011 15:19:22
UPDATE vsites_servico_campo SET campo='certidao_estado',tipo='text',nome='ESTADO',valor='',largura='470',mascara='',site='1',ordenacao='5',obrigatorio='1'
						WHERE id_servico_campo='529';
--14/03/2011 15:19:22
UPDATE vsites_servico_campo SET campo='certidao_cidade',tipo='text',nome='CIDADE',valor='',largura='470',mascara='',site='1',ordenacao='6',obrigatorio='1'
						WHERE id_servico_campo='165';
--14/03/2011 15:19:22
UPDATE vsites_servico_campo SET campo='certidao_comarca_forum',tipo='text',nome='COMARCA',valor='',largura='470',mascara='',site='1',ordenacao='7',obrigatorio='0'
						WHERE id_servico_campo='1675';
--14/03/2011 15:19:22
UPDATE vsites_servico_campo SET campo='certidao_cartorio',tipo='text',nome='CARTORIO',valor='',largura='470',mascara='',site='1',ordenacao='8',obrigatorio='0'
						WHERE id_servico_campo='56';
--14/03/2011 15:19:22
UPDATE vsites_servico_campo SET campo='certidao_qtdd_cartorio',tipo='text',nome='NUMERO DO CARTORIO',valor='',largura='470',mascara='',site='1',ordenacao='9',obrigatorio='1'
						WHERE id_servico_campo='1596';
--14/03/2011 15:19:22
DELETE FROM vsites_servico_campo WHERE id_servico_campo = '' AND id_servico='5';
--04/05/2011 12:04:15
UPDATE vsites_servico SET dias='', status='Ativo', descricao='2º Via de Registro de Sentença', site='1' WHERE id_servico='189';
--04/05/2011 12:04:15
INSERT INTO vsites_servico_campo (id_servico, campo, nome, tipo, largura, site, ordenacao) VALUES ('189','certidao_nome','NOME','text','470','1','1');
--04/05/2011 12:04:15
INSERT INTO vsites_servico_campo (id_servico, campo, nome, tipo, largura, site, ordenacao) VALUES ('189','certidao_pai','PAI','text','470','1','2');
--04/05/2011 12:04:15
INSERT INTO vsites_servico_campo (id_servico, campo, nome, tipo, largura, site, ordenacao) VALUES ('189','certidao_mae','MAE','text','470','1','3');
--04/05/2011 12:04:15
INSERT INTO vsites_servico_campo (id_servico, campo, nome, tipo, largura, site, ordenacao) VALUES ('189','certidao_data_nascimento','DATA DE NASCIMENTO','text','470','1','4');
--04/05/2011 12:04:15
INSERT INTO vsites_servico_campo (id_servico, campo, nome, tipo, largura, site, ordenacao) VALUES ('189','certidao_livro','LIVRO','text','470','1','5');
--04/05/2011 12:04:15
INSERT INTO vsites_servico_campo (id_servico, campo, nome, tipo, largura, site, ordenacao) VALUES ('189','certidao_folha','FOLHA','text','470','1','6');
--04/05/2011 12:04:15
INSERT INTO vsites_servico_campo (id_servico, campo, nome, tipo, largura, site, ordenacao) VALUES ('189','certidao_termo','TERMO','text','470','1','7');
--04/05/2011 12:04:15
DELETE FROM vsites_servico_campo WHERE id_servico_campo = '' AND id_servico='189';
--04/05/2011 12:10:17
UPDATE vsites_servico SET dias='', status='Ativo', descricao='2º Via de Registro de Sentença', site='1' WHERE id_servico='189';
--04/05/2011 12:10:17
UPDATE vsites_servico_campo SET campo='certidao_nome',tipo='text',nome='NOME',valor='',largura='470',mascara='',site='1',ordenacao='1',obrigatorio='0'
						WHERE id_servico_campo='1687';
--04/05/2011 12:10:17
UPDATE vsites_servico_campo SET campo='certidao_pai',tipo='text',nome='PAI',valor='',largura='470',mascara='',site='1',ordenacao='2',obrigatorio='0'
						WHERE id_servico_campo='1688';
--04/05/2011 12:10:18
UPDATE vsites_servico_campo SET campo='certidao_mae',tipo='text',nome='MAE',valor='',largura='470',mascara='',site='1',ordenacao='3',obrigatorio='0'
						WHERE id_servico_campo='1689';
--04/05/2011 12:10:18
UPDATE vsites_servico_campo SET campo='certidao_data_nascimento',tipo='text',nome='DATA DE NASCIMENTO',valor='',largura='470',mascara='',site='1',ordenacao='4',obrigatorio='0'
						WHERE id_servico_campo='1690';
--04/05/2011 12:10:18
UPDATE vsites_servico_campo SET campo='certidao_livro',tipo='text',nome='LIVRO',valor='',largura='470',mascara='',site='1',ordenacao='5',obrigatorio='0'
						WHERE id_servico_campo='1691';
--04/05/2011 12:10:18
UPDATE vsites_servico_campo SET campo='certidao_folha',tipo='text',nome='FOLHA',valor='',largura='470',mascara='',site='1',ordenacao='6',obrigatorio='0'
						WHERE id_servico_campo='1692';
--04/05/2011 12:10:18
UPDATE vsites_servico_campo SET campo='certidao_termo',tipo='text',nome='TERMO',valor='',largura='470',mascara='',site='1',ordenacao='7',obrigatorio='0'
						WHERE id_servico_campo='1693';
--04/05/2011 12:10:18
INSERT INTO vsites_servico_campo (id_servico, campo, nome, tipo, largura, site, ordenacao) VALUES ('189','certidao_registro','REGISTRO','text','470','1','8');
--04/05/2011 12:10:18
INSERT INTO vsites_servico_campo (id_servico, campo, nome, tipo, largura, site, ordenacao) VALUES ('189','certidao_estado','ESTADO','text','470','1','9');
--04/05/2011 12:10:19
INSERT INTO vsites_servico_campo (id_servico, campo, nome, tipo, largura, site, ordenacao) VALUES ('189','certidao_cidade','CIDADE','text','470','1','10');
--04/05/2011 12:10:19
INSERT INTO vsites_servico_campo (id_servico, campo, nome, tipo, largura, site, ordenacao) VALUES ('189','certidao_cartorio_cep','CEP','text','470','1','11');
--04/05/2011 12:10:19
INSERT INTO vsites_servico_campo (id_servico, campo, nome, tipo, largura, site, ordenacao) VALUES ('189','certidao_data_registro','DATA DO REGISTRO','text','470','1','12');
--04/05/2011 12:10:19
INSERT INTO vsites_servico_campo (id_servico, campo, nome, tipo, largura, site, ordenacao) VALUES ('189','certidao_protocolo','PROTOCOLO','text','470','0','13');
--04/05/2011 12:10:19
INSERT INTO vsites_servico_campo (id_servico, campo, nome, tipo, largura, site, ordenacao) VALUES ('189','certidao_averbacao','AVERBAÇÃO','text','470','0','14');
--04/05/2011 12:10:20
INSERT INTO vsites_servico_campo (id_servico, campo, nome, tipo, largura, site, ordenacao) VALUES ('189','certidao_finalidade','FINALIDADE DO DOCUMENTO','text','470','0','15');
--04/05/2011 12:10:20
INSERT INTO vsites_servico_campo (id_servico, campo, nome, tipo, largura, site, ordenacao) VALUES ('189','certidao_tem_copia_doc','TEM COPIA DO DOCUMENTO','text','470','0','16');
--04/05/2011 12:10:20
DELETE FROM vsites_servico_campo WHERE id_servico_campo = '' AND id_servico='189';
--23/05/2011 11:03:11
UPDATE vsites_servico SET dias='', status='Ativo', descricao='Tutela e Curatela (Interdição)', site='1' WHERE id_servico='67';
--23/05/2011 11:03:11
UPDATE vsites_servico_campo SET campo='certidao_nome',tipo='text',nome='NOME',valor='',largura='470',mascara='',site='1',ordenacao='1',obrigatorio='1'
						WHERE id_servico_campo='819';
--23/05/2011 11:03:11
UPDATE vsites_servico_campo SET campo='certidao_data_nascimento',tipo='text',nome='DATA NASCIMENTO',valor='',largura='470',mascara='',site='1',ordenacao='2',obrigatorio='0'
						WHERE id_servico_campo='1629';
--23/05/2011 11:03:11
UPDATE vsites_servico_campo SET campo='certidao_orgao_emissor',tipo='text',nome='ORGAO EMISSOR',valor='',largura='470',mascara='',site='1',ordenacao='3',obrigatorio='1'
						WHERE id_servico_campo='901';
--23/05/2011 11:03:11
UPDATE vsites_servico_campo SET campo='certidao_rg',tipo='text',nome='RG',valor='',largura='470',mascara='',site='1',ordenacao='4',obrigatorio='1'
						WHERE id_servico_campo='1205';
--23/05/2011 11:03:11
UPDATE vsites_servico_campo SET campo='certidao_data_expedicao',tipo='text',nome='DATA DE EXPEDICAO',valor='',largura='470',mascara='',site='1',ordenacao='5',obrigatorio='1'
						WHERE id_servico_campo='383';
--23/05/2011 11:03:11
UPDATE vsites_servico_campo SET campo='certidao_cpf',tipo='text',nome='CPF',valor='',largura='470',mascara='',site='1',ordenacao='6',obrigatorio='1'
						WHERE id_servico_campo='353';
--23/05/2011 11:03:11
UPDATE vsites_servico_campo SET campo='certidao_nacionalidade',tipo='text',nome='NATURALIDADE',valor='',largura='470',mascara='',site='1',ordenacao='7',obrigatorio='1'
						WHERE id_servico_campo='722';
--23/05/2011 11:03:11
UPDATE vsites_servico_campo SET campo='certidao_estado',tipo='text',nome='ESTADO',valor='',largura='470',mascara='',site='1',ordenacao='8',obrigatorio='1'
						WHERE id_servico_campo='564';
--23/05/2011 11:03:11
UPDATE vsites_servico_campo SET campo='certidao_cidade',tipo='text',nome='CIDADE',valor='',largura='470',mascara='',site='1',ordenacao='9',obrigatorio='1'
						WHERE id_servico_campo='200';
--23/05/2011 11:03:11
UPDATE vsites_servico_campo SET campo='certidao_mae',tipo='text',nome='MAE',valor='',largura='470',mascara='',site='1',ordenacao='10',obrigatorio='1'
						WHERE id_servico_campo='660';
--23/05/2011 11:03:11
UPDATE vsites_servico_campo SET campo='certidao_pai',tipo='text',nome='PAI',valor='',largura='470',mascara='',site='1',ordenacao='11',obrigatorio='0'
						WHERE id_servico_campo='926';
--23/05/2011 11:03:11
UPDATE vsites_servico_campo SET campo='certidao_finalidade',tipo='text',nome='FINALIDADE',valor='',largura='470',mascara='',site='1',ordenacao='12',obrigatorio='0'
						WHERE id_servico_campo='1552';
--23/05/2011 11:03:11
DELETE FROM vsites_servico_campo WHERE id_servico_campo = '' AND id_servico='67';
--25/05/2011 11:02:35
INSERT INTO vsites_servico (id_departamento, status, site, descricao) VALUES ('4','Ativo','','Assessoria');
--25/05/2011 11:02:35
INSERT INTO vsites_servico_campo (id_servico, campo, nome, tipo, largura, site, ordenacao) VALUES ('195','certidao_nome','NOME','text','470','0','1');
--25/05/2011 11:04:12
INSERT INTO vsites_servico (id_departamento, status, site, descricao) VALUES ('4','Ativo','','Consultoria');
--25/05/2011 11:04:12
INSERT INTO vsites_servico_campo (id_servico, campo, nome, tipo, largura, site, ordenacao) VALUES ('196','certidao_nome','NOME','text','470','0','1');
--26/05/2011 12:22:38
UPDATE vsites_servico SET dias='', status='Ativo', descricao='Antecedentes Criminais', site='1',desc_site='28',servico_desc='' WHERE id_servico='';
--26/05/2011 12:22:38
UPDATE vsites_servico_campo SET campo='certidao_nome',tipo='text',nome='NOME',valor='',largura='470',mascara='',site='1',ordenacao='1',obrigatorio='1'
						WHERE id_servico_campo='729';
--26/05/2011 12:22:38
UPDATE vsites_servico_campo SET campo='certidao_orgao_emissor',tipo='text',nome='ORGAO EMISSOR',valor='',largura='470',mascara='',site='1',ordenacao='2',obrigatorio='1'
						WHERE id_servico_campo='884';
--26/05/2011 12:22:38
UPDATE vsites_servico_campo SET campo='certidao_rg',tipo='text',nome='RG',valor='',largura='470',mascara='',site='1',ordenacao='3',obrigatorio='1'
						WHERE id_servico_campo='1137';
--26/05/2011 12:22:38
UPDATE vsites_servico_campo SET campo='certidao_data_expedicao',tipo='text',nome='DATA DE EXPEDICAO',valor='',largura='470',mascara='',site='1',ordenacao='4',obrigatorio='1'
						WHERE id_servico_campo='372';
--26/05/2011 12:22:38
UPDATE vsites_servico_campo SET campo='certidao_cpf',tipo='text',nome='CPF',valor='',largura='470',mascara='',site='1',ordenacao='5',obrigatorio='1'
						WHERE id_servico_campo='286';
--26/05/2011 12:22:38
UPDATE vsites_servico_campo SET campo='certidao_nacionalidade',tipo='text',nome='NATURALIDADE',valor='',largura='470',mascara='',site='1',ordenacao='6',obrigatorio='1'
						WHERE id_servico_campo='717';
--26/05/2011 12:22:38
UPDATE vsites_servico_campo SET campo='certidao_estado',tipo='text',nome='ESTADO',valor='',largura='470',mascara='',site='1',ordenacao='7',obrigatorio='1'
						WHERE id_servico_campo='472';
--26/05/2011 12:22:38
UPDATE vsites_servico_campo SET campo='certidao_cidade',tipo='text',nome='CIDADE',valor='',largura='470',mascara='',site='1',ordenacao='8',obrigatorio='1'
						WHERE id_servico_campo='106';
--26/05/2011 12:22:38
UPDATE vsites_servico_campo SET campo='certidao_mae',tipo='text',nome='MAE',valor='',largura='470',mascara='',site='1',ordenacao='9',obrigatorio='1'
						WHERE id_servico_campo='639';
--26/05/2011 12:22:38
UPDATE vsites_servico_campo SET campo='certidao_pai',tipo='text',nome='PAI',valor='',largura='470',mascara='',site='1',ordenacao='10',obrigatorio='0'
						WHERE id_servico_campo='905';
--26/05/2011 12:22:38
UPDATE vsites_servico_campo SET campo='certidao_cartorio',tipo='text',nome='CARTORIO',valor='',largura='470',mascara='',site='1',ordenacao='11',obrigatorio='0'
						WHERE id_servico_campo='25';
--26/05/2011 12:22:38
DELETE FROM vsites_servico_campo WHERE id_servico_campo = '' AND id_servico='28';
--26/05/2011 12:23:06
UPDATE vsites_servico SET dias='', status='Ativo', descricao='Antecedentes Criminais', site='1',desc_site='28',servico_desc='111' WHERE id_servico='1112';
--26/05/2011 12:23:06
UPDATE vsites_servico_campo SET campo='certidao_nome',tipo='text',nome='NOME',valor='',largura='470',mascara='',site='1',ordenacao='1',obrigatorio='1'
						WHERE id_servico_campo='729';
--26/05/2011 12:23:06
UPDATE vsites_servico_campo SET campo='certidao_orgao_emissor',tipo='text',nome='ORGAO EMISSOR',valor='',largura='470',mascara='',site='1',ordenacao='2',obrigatorio='1'
						WHERE id_servico_campo='884';
--26/05/2011 12:23:06
UPDATE vsites_servico_campo SET campo='certidao_rg',tipo='text',nome='RG',valor='',largura='470',mascara='',site='1',ordenacao='3',obrigatorio='1'
						WHERE id_servico_campo='1137';
--26/05/2011 12:23:06
UPDATE vsites_servico_campo SET campo='certidao_data_expedicao',tipo='text',nome='DATA DE EXPEDICAO',valor='',largura='470',mascara='',site='1',ordenacao='4',obrigatorio='1'
						WHERE id_servico_campo='372';
--26/05/2011 12:23:06
UPDATE vsites_servico_campo SET campo='certidao_cpf',tipo='text',nome='CPF',valor='',largura='470',mascara='',site='1',ordenacao='5',obrigatorio='1'
						WHERE id_servico_campo='286';
--26/05/2011 12:23:06
UPDATE vsites_servico_campo SET campo='certidao_nacionalidade',tipo='text',nome='NATURALIDADE',valor='',largura='470',mascara='',site='1',ordenacao='6',obrigatorio='1'
						WHERE id_servico_campo='717';
--26/05/2011 12:23:06
UPDATE vsites_servico_campo SET campo='certidao_estado',tipo='text',nome='ESTADO',valor='',largura='470',mascara='',site='1',ordenacao='7',obrigatorio='1'
						WHERE id_servico_campo='472';
--26/05/2011 12:23:06
UPDATE vsites_servico_campo SET campo='certidao_cidade',tipo='text',nome='CIDADE',valor='',largura='470',mascara='',site='1',ordenacao='8',obrigatorio='1'
						WHERE id_servico_campo='106';
--26/05/2011 12:23:06
UPDATE vsites_servico_campo SET campo='certidao_mae',tipo='text',nome='MAE',valor='',largura='470',mascara='',site='1',ordenacao='9',obrigatorio='1'
						WHERE id_servico_campo='639';
--26/05/2011 12:23:06
UPDATE vsites_servico_campo SET campo='certidao_pai',tipo='text',nome='PAI',valor='',largura='470',mascara='',site='1',ordenacao='10',obrigatorio='0'
						WHERE id_servico_campo='905';
--26/05/2011 12:23:06
UPDATE vsites_servico_campo SET campo='certidao_cartorio',tipo='text',nome='CARTORIO',valor='',largura='470',mascara='',site='1',ordenacao='11',obrigatorio='0'
						WHERE id_servico_campo='25';
--26/05/2011 12:23:06
DELETE FROM vsites_servico_campo WHERE id_servico_campo = '' AND id_servico='28';
--26/05/2011 12:24:35
UPDATE vsites_servico SET dias='', status='Ativo', descricao='Certidão de Matrícula Atualizada com Negativa de Ônus', site='1',desc_site='156',servico_desc='111' WHERE id_servico='<p> Além da descrição que consta na matrícula atualizada, consta também todos os ônus reais que pesam sobre o imóvel. Ônus são compromissos que pesam sobre um determinado bem: hipoteca, penhora doação em usufruto, etc. 
</p>';
--26/05/2011 12:24:35
UPDATE vsites_servico_campo SET campo='certidao_cartorio',tipo='text',nome='CARTÓRIO',valor='',largura='470',mascara='',site='1',ordenacao='1',obrigatorio='1'
						WHERE id_servico_campo='1380';
--26/05/2011 12:24:35
UPDATE vsites_servico_campo SET campo='certidao_matricula',tipo='text',nome='MATRÍCULA',valor='',largura='470',mascara='',site='1',ordenacao='2',obrigatorio='1'
						WHERE id_servico_campo='1381';
--26/05/2011 12:24:35
UPDATE vsites_servico_campo SET campo='certidao_estado',tipo='text',nome='UF',valor='',largura='470',mascara='',site='1',ordenacao='3',obrigatorio='1'
						WHERE id_servico_campo='1383';
--26/05/2011 12:24:35
UPDATE vsites_servico_campo SET campo='certidao_cidade',tipo='text',nome='CIDADE',valor='',largura='470',mascara='',site='1',ordenacao='4',obrigatorio='1'
						WHERE id_servico_campo='1382';
--26/05/2011 12:24:35
DELETE FROM vsites_servico_campo WHERE id_servico_campo = '' AND id_servico='156';
--26/05/2011 12:32:42
UPDATE vsites_servico SET dias='', status='Ativo', descricao='Certidão de Matrícula Atualizada com Negativa de Ônus', site='1',desc_site='156',servico_desc='dddddd' WHERE id_servico='<p> Além da descrição que consta na matrícula atualizada, consta também todos os ônus reais que pesam sobre o imóvel. Ônus são compromissos que pesam sobre um determinado bem: hipoteca, penhora doação em usufruto, etc. 
</p>';
--26/05/2011 12:32:42
UPDATE vsites_servico_campo SET campo='certidao_cartorio',tipo='text',nome='CARTÓRIO',valor='',largura='470',mascara='',site='1',ordenacao='1',obrigatorio='1'
						WHERE id_servico_campo='1380';
--26/05/2011 12:32:42
UPDATE vsites_servico_campo SET campo='certidao_matricula',tipo='text',nome='MATRÍCULA',valor='',largura='470',mascara='',site='1',ordenacao='2',obrigatorio='1'
						WHERE id_servico_campo='1381';
--26/05/2011 12:32:42
UPDATE vsites_servico_campo SET campo='certidao_estado',tipo='text',nome='UF',valor='',largura='470',mascara='',site='1',ordenacao='3',obrigatorio='1'
						WHERE id_servico_campo='1383';
--26/05/2011 12:32:42
UPDATE vsites_servico_campo SET campo='certidao_cidade',tipo='text',nome='CIDADE',valor='',largura='470',mascara='',site='1',ordenacao='4',obrigatorio='1'
						WHERE id_servico_campo='1382';
--26/05/2011 12:32:42
DELETE FROM vsites_servico_campo WHERE id_servico_campo = '' AND id_servico='156';
--26/05/2011 12:36:26
UPDATE vsites_servico SET dias='', status='Ativo', descricao='Certidão de Matrícula Atualizada com Negativa de Ônus', site='1',desc_site='156',servico_desc='dsds' WHERE id_servico='<p> Além da descrição que consta na matrícula atualizada, consta também todos os ônus reais que pesam sobre o imóvel. Ônus são compromissos que pesam sobre um determinado bem: hipoteca, penhora doação em usufruto, etc. 
</p>';
--26/05/2011 12:36:26
UPDATE vsites_servico_campo SET campo='certidao_cartorio',tipo='text',nome='CARTÓRIO',valor='',largura='470',mascara='',site='1',ordenacao='1',obrigatorio='1'
						WHERE id_servico_campo='1380';
--26/05/2011 12:36:26
UPDATE vsites_servico_campo SET campo='certidao_matricula',tipo='text',nome='MATRÍCULA',valor='',largura='470',mascara='',site='1',ordenacao='2',obrigatorio='1'
						WHERE id_servico_campo='1381';
--26/05/2011 12:36:26
UPDATE vsites_servico_campo SET campo='certidao_estado',tipo='text',nome='UF',valor='',largura='470',mascara='',site='1',ordenacao='3',obrigatorio='1'
						WHERE id_servico_campo='1383';
--26/05/2011 12:36:26
UPDATE vsites_servico_campo SET campo='certidao_cidade',tipo='text',nome='CIDADE',valor='',largura='470',mascara='',site='1',ordenacao='4',obrigatorio='1'
						WHERE id_servico_campo='1382';
--26/05/2011 12:36:26
DELETE FROM vsites_servico_campo WHERE id_servico_campo = '' AND id_servico='156';
--26/05/2011 12:37:34
UPDATE vsites_servico SET dias='', status='Ativo', descricao='Certidão de Matrícula Atualizada com Negativa de Ônus', site='1',desc_site='ss',servico_desc='<p> Além da descrição que consta na matrícula atualizada, consta também todos os ônus reais que pesam sobre o imóvel. Ônus são compromissos que pesam sobre um determinado bem: hipoteca, penhora doação em usufruto, etc. 
</p>' WHERE id_servico='156';
--26/05/2011 12:37:34
UPDATE vsites_servico_campo SET campo='certidao_cartorio',tipo='text',nome='CARTÓRIO',valor='',largura='470',mascara='',site='1',ordenacao='1',obrigatorio='1'
						WHERE id_servico_campo='1380';
--26/05/2011 12:37:34
UPDATE vsites_servico_campo SET campo='certidao_matricula',tipo='text',nome='MATRÍCULA',valor='',largura='470',mascara='',site='1',ordenacao='2',obrigatorio='1'
						WHERE id_servico_campo='1381';
--26/05/2011 12:37:34
UPDATE vsites_servico_campo SET campo='certidao_estado',tipo='text',nome='UF',valor='',largura='470',mascara='',site='1',ordenacao='3',obrigatorio='1'
						WHERE id_servico_campo='1383';
--26/05/2011 12:37:34
UPDATE vsites_servico_campo SET campo='certidao_cidade',tipo='text',nome='CIDADE',valor='',largura='470',mascara='',site='1',ordenacao='4',obrigatorio='1'
						WHERE id_servico_campo='1382';
--26/05/2011 12:37:34
DELETE FROM vsites_servico_campo WHERE id_servico_campo = '' AND id_servico='156';
--26/05/2011 12:48:49
UPDATE vsites_servico SET dias='', status='Ativo', descricao='Anotação - Óbito', site='1',desc_site='',servico_desc='',site_menu='1' WHERE id_servico='30';
--26/05/2011 12:48:49
UPDATE vsites_servico_campo SET campo='certidao_nome',tipo='text',nome='NOME',valor='',largura='470',mascara='',site='1',ordenacao='1',obrigatorio='1'
						WHERE id_servico_campo='728';
--26/05/2011 12:48:49
UPDATE vsites_servico_campo SET campo='certidao_conjuge',tipo='text',nome='CONJUGE',valor='',largura='470',mascara='',site='1',ordenacao='2',obrigatorio='0'
						WHERE id_servico_campo='272';
--26/05/2011 12:48:49
UPDATE vsites_servico_campo SET campo='certidao_pai',tipo='text',nome='PAI',valor='',largura='470',mascara='',site='1',ordenacao='3',obrigatorio='0'
						WHERE id_servico_campo='904';
--26/05/2011 12:48:49
UPDATE vsites_servico_campo SET campo='certidao_mae',tipo='text',nome='MAE',valor='',largura='470',mascara='',site='1',ordenacao='4',obrigatorio='0'
						WHERE id_servico_campo='638';
--26/05/2011 12:48:49
UPDATE vsites_servico_campo SET campo='certidao_data_casamento',tipo='text',nome='DATA DE CASAMENTO',valor='',largura='470',mascara='',site='1',ordenacao='5',obrigatorio='0'
						WHERE id_servico_campo='369';
--26/05/2011 12:48:49
UPDATE vsites_servico_campo SET campo='certidao_data_nascimento',tipo='text',nome='DATA DE NASCIMENTO',valor='',largura='470',mascara='',site='1',ordenacao='6',obrigatorio='0'
						WHERE id_servico_campo='1504';
--26/05/2011 12:48:49
UPDATE vsites_servico_campo SET campo='certidao_livro',tipo='text',nome='LIVRO',valor='',largura='470',mascara='',site='1',ordenacao='7',obrigatorio='0'
						WHERE id_servico_campo='616';
--26/05/2011 12:48:49
UPDATE vsites_servico_campo SET campo='certidao_folha',tipo='text',nome='FOLHA',valor='',largura='470',mascara='',site='1',ordenacao='8',obrigatorio='0'
						WHERE id_servico_campo='592';
--26/05/2011 12:48:49
UPDATE vsites_servico_campo SET campo='certidao_registro',tipo='text',nome='REGISTRO',valor='',largura='470',mascara='',site='1',ordenacao='9',obrigatorio='0'
						WHERE id_servico_campo='1041';
--26/05/2011 12:48:49
UPDATE vsites_servico_campo SET campo='certidao_estado',tipo='text',nome='ESTADO',valor='',largura='470',mascara='',site='1',ordenacao='10',obrigatorio='1'
						WHERE id_servico_campo='471';
--26/05/2011 12:48:49
UPDATE vsites_servico_campo SET campo='certidao_cidade',tipo='text',nome='CIDADE',valor='',largura='470',mascara='',site='1',ordenacao='11',obrigatorio='1'
						WHERE id_servico_campo='105';
--26/05/2011 12:48:49
UPDATE vsites_servico_campo SET campo='certidao_cartorio',tipo='text',nome='CARTÓRIO',valor='',largura='470',mascara='',site='1',ordenacao='12',obrigatorio='0'
						WHERE id_servico_campo='82';
--26/05/2011 12:48:49
UPDATE vsites_servico_campo SET campo='certidao_averbacao',tipo='text',nome='AVERBACAO',valor='',largura='470',mascara='',site='1',ordenacao='13',obrigatorio='0'
						WHERE id_servico_campo='2';
--26/05/2011 12:48:49
UPDATE vsites_servico_campo SET campo='certidao_finalidade',tipo='text',nome='FINALIDADE DO DOCUMENTO',valor='',largura='470',mascara='',site='1',ordenacao='14',obrigatorio='0'
						WHERE id_servico_campo='574';
--26/05/2011 12:48:49
UPDATE vsites_servico_campo SET campo='certidao_data_registro',tipo='text',nome='DATA DE REGISTRO',valor='',largura='470',mascara='',site='1',ordenacao='15',obrigatorio='0'
						WHERE id_servico_campo='1603';
--26/05/2011 12:48:49
DELETE FROM vsites_servico_campo WHERE id_servico_campo = '' AND id_servico='30';
--26/05/2011 12:49:58
UPDATE vsites_servico SET dias='', status='Ativo', descricao='Anotação - Óbito', site='1',desc_site='Certidão de Anotação - Óbito',servico_desc='',site_menu='1' WHERE id_servico='30';
--26/05/2011 12:49:58
UPDATE vsites_servico_campo SET campo='certidao_nome',tipo='text',nome='NOME',valor='',largura='470',mascara='',site='1',ordenacao='1',obrigatorio='1'
						WHERE id_servico_campo='728';
--26/05/2011 12:49:58
UPDATE vsites_servico_campo SET campo='certidao_conjuge',tipo='text',nome='CONJUGE',valor='',largura='470',mascara='',site='1',ordenacao='2',obrigatorio='0'
						WHERE id_servico_campo='272';
--26/05/2011 12:49:58
UPDATE vsites_servico_campo SET campo='certidao_pai',tipo='text',nome='PAI',valor='',largura='470',mascara='',site='1',ordenacao='3',obrigatorio='0'
						WHERE id_servico_campo='904';
--26/05/2011 12:49:58
UPDATE vsites_servico_campo SET campo='certidao_mae',tipo='text',nome='MAE',valor='',largura='470',mascara='',site='1',ordenacao='4',obrigatorio='0'
						WHERE id_servico_campo='638';
--26/05/2011 12:49:58
UPDATE vsites_servico_campo SET campo='certidao_data_casamento',tipo='text',nome='DATA DE CASAMENTO',valor='',largura='470',mascara='',site='1',ordenacao='5',obrigatorio='0'
						WHERE id_servico_campo='369';
--26/05/2011 12:49:58
UPDATE vsites_servico_campo SET campo='certidao_data_nascimento',tipo='text',nome='DATA DE NASCIMENTO',valor='',largura='470',mascara='',site='1',ordenacao='6',obrigatorio='0'
						WHERE id_servico_campo='1504';
--26/05/2011 12:49:58
UPDATE vsites_servico_campo SET campo='certidao_livro',tipo='text',nome='LIVRO',valor='',largura='470',mascara='',site='1',ordenacao='7',obrigatorio='0'
						WHERE id_servico_campo='616';
--26/05/2011 12:49:58
UPDATE vsites_servico_campo SET campo='certidao_folha',tipo='text',nome='FOLHA',valor='',largura='470',mascara='',site='1',ordenacao='8',obrigatorio='0'
						WHERE id_servico_campo='592';
--26/05/2011 12:49:58
UPDATE vsites_servico_campo SET campo='certidao_registro',tipo='text',nome='REGISTRO',valor='',largura='470',mascara='',site='1',ordenacao='9',obrigatorio='0'
						WHERE id_servico_campo='1041';
--26/05/2011 12:49:58
UPDATE vsites_servico_campo SET campo='certidao_estado',tipo='text',nome='ESTADO',valor='',largura='470',mascara='',site='1',ordenacao='10',obrigatorio='1'
						WHERE id_servico_campo='471';
--26/05/2011 12:49:58
UPDATE vsites_servico_campo SET campo='certidao_cidade',tipo='text',nome='CIDADE',valor='',largura='470',mascara='',site='1',ordenacao='11',obrigatorio='1'
						WHERE id_servico_campo='105';
--26/05/2011 12:49:58
UPDATE vsites_servico_campo SET campo='certidao_cartorio',tipo='text',nome='CARTÓRIO',valor='',largura='470',mascara='',site='1',ordenacao='12',obrigatorio='0'
						WHERE id_servico_campo='82';
--26/05/2011 12:49:58
UPDATE vsites_servico_campo SET campo='certidao_averbacao',tipo='text',nome='AVERBACAO',valor='',largura='470',mascara='',site='1',ordenacao='13',obrigatorio='0'
						WHERE id_servico_campo='2';
--26/05/2011 12:49:58
UPDATE vsites_servico_campo SET campo='certidao_finalidade',tipo='text',nome='FINALIDADE DO DOCUMENTO',valor='',largura='470',mascara='',site='1',ordenacao='14',obrigatorio='0'
						WHERE id_servico_campo='574';
--26/05/2011 12:49:58
UPDATE vsites_servico_campo SET campo='certidao_data_registro',tipo='text',nome='DATA DE REGISTRO',valor='',largura='470',mascara='',site='1',ordenacao='15',obrigatorio='0'
						WHERE id_servico_campo='1603';
--26/05/2011 12:49:58
DELETE FROM vsites_servico_campo WHERE id_servico_campo = '' AND id_servico='30';
--26/05/2011 12:55:25
UPDATE vsites_servico SET dias='', status='Ativo', descricao='Nascimento', site='1',desc_site='Certidão de Nasciemento',servico_desc='',site_menu='' WHERE id_servico='2';
--26/05/2011 12:55:25
UPDATE vsites_servico_campo SET campo='certidao_nome',tipo='text',nome='NOME',valor='',largura='470',mascara='',site='1',ordenacao='1',obrigatorio='1'
						WHERE id_servico_campo='785';
--26/05/2011 12:55:25
UPDATE vsites_servico_campo SET campo='certidao_pai',tipo='text',nome='PAI',valor='',largura='470',mascara='',site='1',ordenacao='2',obrigatorio='0'
						WHERE id_servico_campo='921';
--26/05/2011 12:55:25
UPDATE vsites_servico_campo SET campo='certidao_mae',tipo='text',nome='MAE',valor='',largura='470',mascara='',site='1',ordenacao='3',obrigatorio='1'
						WHERE id_servico_campo='655';
--26/05/2011 12:55:25
UPDATE vsites_servico_campo SET campo='certidao_data_nascimento',tipo='text',nome='DATA DE NASCIMENTO',valor='',largura='470',mascara='',site='1',ordenacao='4',obrigatorio='1'
						WHERE id_servico_campo='404';
--26/05/2011 12:55:25
UPDATE vsites_servico_campo SET campo='certidao_livro',tipo='text',nome='LIVRO',valor='',largura='470',mascara='',site='1',ordenacao='5',obrigatorio='0'
						WHERE id_servico_campo='627';
--26/05/2011 12:55:25
UPDATE vsites_servico_campo SET campo='certidao_folha',tipo='text',nome='FOLHA',valor='',largura='470',mascara='',site='1',ordenacao='6',obrigatorio='0'
						WHERE id_servico_campo='605';
--26/05/2011 12:55:25
UPDATE vsites_servico_campo SET campo='certidao_registro',tipo='text',nome='REGISTRO',valor='',largura='470',mascara='',site='1',ordenacao='7',obrigatorio='0'
						WHERE id_servico_campo='1050';
--26/05/2011 12:55:25
UPDATE vsites_servico_campo SET campo='certidao_estado',tipo='text',nome='ESTADO',valor='',largura='470',mascara='',site='1',ordenacao='8',obrigatorio='1'
						WHERE id_servico_campo='527';
--26/05/2011 12:55:25
UPDATE vsites_servico_campo SET campo='certidao_cidade',tipo='text',nome='CIDADE',valor='',largura='470',mascara='',site='1',ordenacao='9',obrigatorio='1'
						WHERE id_servico_campo='163';
--26/05/2011 12:55:25
UPDATE vsites_servico_campo SET campo='certidao_cartorio',tipo='text',nome='CARTORIO',valor='',largura='470',mascara='',site='1',ordenacao='10',obrigatorio='0'
						WHERE id_servico_campo='54';
--26/05/2011 12:55:25
UPDATE vsites_servico_campo SET campo='certidao_cartorio_cep',tipo='text',nome='CEP DO CARTORIO',valor='',largura='470',mascara='',site='1',ordenacao='11',obrigatorio='0'
						WHERE id_servico_campo='98';
--26/05/2011 12:55:25
UPDATE vsites_servico_campo SET campo='certidao_data_registro',tipo='text',nome='DATA DO REGISTRO',valor='',largura='470',mascara='',site='1',ordenacao='12',obrigatorio='0'
						WHERE id_servico_campo='423';
--26/05/2011 12:55:25
UPDATE vsites_servico_campo SET campo='certidao_protocolo',tipo='text',nome='PROTOCOLO',valor='',largura='470',mascara='',site='0',ordenacao='13',obrigatorio='0'
						WHERE id_servico_campo='1001';
--26/05/2011 12:55:25
UPDATE vsites_servico_campo SET campo='certidao_averbacao',tipo='text',nome='AVERBACAO',valor='',largura='470',mascara='',site='1',ordenacao='14',obrigatorio='0'
						WHERE id_servico_campo='11';
--26/05/2011 12:55:25
UPDATE vsites_servico_campo SET campo='certidao_finalidade',tipo='text',nome='FINALIDADE DO DOCUMENTO',valor='',largura='470',mascara='',site='1',ordenacao='15',obrigatorio='0'
						WHERE id_servico_campo='584';
--26/05/2011 12:55:25
UPDATE vsites_servico_campo SET campo='certidao_tem_copia_doc',tipo='text',nome='TEM COPIA DO DOCUMENTO',valor='',largura='470',mascara='',site='1',ordenacao='16',obrigatorio='0'
						WHERE id_servico_campo='1228';
--26/05/2011 12:55:25
DELETE FROM vsites_servico_campo WHERE id_servico_campo = '' AND id_servico='2';
--26/05/2011 12:55:51
UPDATE vsites_servico SET dias='', status='Ativo', descricao='Casamento', site='1',desc_site='Certidão de Casamento',servico_desc='',site_menu='' WHERE id_servico='3';
--26/05/2011 12:55:51
UPDATE vsites_servico_campo SET campo='certidao_nome',tipo='text',nome='NOME',valor='',largura='470',mascara='',site='1',ordenacao='1',obrigatorio='1'
						WHERE id_servico_campo='745';
--26/05/2011 12:55:51
UPDATE vsites_servico_campo SET campo='certidao_esposa',tipo='text',nome='ESPOSA/ESPOSO',valor='',largura='470',mascara='',site='1',ordenacao='2',obrigatorio='1'
						WHERE id_servico_campo='464';
--26/05/2011 12:55:51
UPDATE vsites_servico_campo SET campo='certidao_data_casamento',tipo='text',nome='DATA DE CASAMENTO',valor='',largura='470',mascara='',site='1',ordenacao='3',obrigatorio='1'
						WHERE id_servico_campo='364';
--26/05/2011 12:55:51
UPDATE vsites_servico_campo SET campo='certidao_livro',tipo='text',nome='LIVRO',valor='',largura='470',mascara='',site='1',ordenacao='4',obrigatorio='0'
						WHERE id_servico_campo='619';
--26/05/2011 12:55:51
UPDATE vsites_servico_campo SET campo='certidao_folha',tipo='text',nome='FOLHA',valor='',largura='470',mascara='',site='1',ordenacao='5',obrigatorio='0'
						WHERE id_servico_campo='596';
--26/05/2011 12:55:51
UPDATE vsites_servico_campo SET campo='certidao_registro',tipo='text',nome='REGISTRO',valor='',largura='470',mascara='',site='1',ordenacao='6',obrigatorio='0'
						WHERE id_servico_campo='1044';
--26/05/2011 12:55:51
UPDATE vsites_servico_campo SET campo='certidao_estado',tipo='text',nome='ESTADO',valor='',largura='470',mascara='',site='1',ordenacao='7',obrigatorio='1'
						WHERE id_servico_campo='488';
--26/05/2011 12:55:51
UPDATE vsites_servico_campo SET campo='certidao_cidade',tipo='text',nome='CIDADE',valor='',largura='470',mascara='',site='1',ordenacao='8',obrigatorio='1'
						WHERE id_servico_campo='122';
--26/05/2011 12:55:51
UPDATE vsites_servico_campo SET campo='certidao_averbacao',tipo='text',nome='AVERBACAO',valor='',largura='470',mascara='',site='1',ordenacao='9',obrigatorio='0'
						WHERE id_servico_campo='5';
--26/05/2011 12:55:51
UPDATE vsites_servico_campo SET campo='certidao_cartorio',tipo='text',nome='CARTORIO',valor='',largura='470',mascara='',site='1',ordenacao='10',obrigatorio='0'
						WHERE id_servico_campo='34';
--26/05/2011 12:55:51
UPDATE vsites_servico_campo SET campo='certidao_finalidade',tipo='text',nome='FINALIDADE DO DOCUMENTO',valor='',largura='470',mascara='',site='1',ordenacao='11',obrigatorio='0'
						WHERE id_servico_campo='578';
--26/05/2011 12:55:51
DELETE FROM vsites_servico_campo WHERE id_servico_campo = '' AND id_servico='3';
--26/05/2011 12:56:14
UPDATE vsites_servico SET dias='', status='Ativo', descricao='Casamento', site='1',desc_site='Certidão de Casamento',servico_desc='',site_menu='1' WHERE id_servico='3';
--26/05/2011 12:56:14
UPDATE vsites_servico_campo SET campo='certidao_nome',tipo='text',nome='NOME',valor='',largura='470',mascara='',site='1',ordenacao='1',obrigatorio='1'
						WHERE id_servico_campo='745';
--26/05/2011 12:56:14
UPDATE vsites_servico_campo SET campo='certidao_esposa',tipo='text',nome='ESPOSA/ESPOSO',valor='',largura='470',mascara='',site='1',ordenacao='2',obrigatorio='1'
						WHERE id_servico_campo='464';
--26/05/2011 12:56:14
UPDATE vsites_servico_campo SET campo='certidao_data_casamento',tipo='text',nome='DATA DE CASAMENTO',valor='',largura='470',mascara='',site='1',ordenacao='3',obrigatorio='1'
						WHERE id_servico_campo='364';
--26/05/2011 12:56:14
UPDATE vsites_servico_campo SET campo='certidao_livro',tipo='text',nome='LIVRO',valor='',largura='470',mascara='',site='1',ordenacao='4',obrigatorio='0'
						WHERE id_servico_campo='619';
--26/05/2011 12:56:14
UPDATE vsites_servico_campo SET campo='certidao_folha',tipo='text',nome='FOLHA',valor='',largura='470',mascara='',site='1',ordenacao='5',obrigatorio='0'
						WHERE id_servico_campo='596';
--26/05/2011 12:56:14
UPDATE vsites_servico_campo SET campo='certidao_registro',tipo='text',nome='REGISTRO',valor='',largura='470',mascara='',site='1',ordenacao='6',obrigatorio='0'
						WHERE id_servico_campo='1044';
--26/05/2011 12:56:14
UPDATE vsites_servico_campo SET campo='certidao_estado',tipo='text',nome='ESTADO',valor='',largura='470',mascara='',site='1',ordenacao='7',obrigatorio='1'
						WHERE id_servico_campo='488';
--26/05/2011 12:56:14
UPDATE vsites_servico_campo SET campo='certidao_cidade',tipo='text',nome='CIDADE',valor='',largura='470',mascara='',site='1',ordenacao='8',obrigatorio='1'
						WHERE id_servico_campo='122';
--26/05/2011 12:56:14
UPDATE vsites_servico_campo SET campo='certidao_averbacao',tipo='text',nome='AVERBACAO',valor='',largura='470',mascara='',site='1',ordenacao='9',obrigatorio='0'
						WHERE id_servico_campo='5';
--26/05/2011 12:56:14
UPDATE vsites_servico_campo SET campo='certidao_cartorio',tipo='text',nome='CARTORIO',valor='',largura='470',mascara='',site='1',ordenacao='10',obrigatorio='0'
						WHERE id_servico_campo='34';
--26/05/2011 12:56:14
UPDATE vsites_servico_campo SET campo='certidao_finalidade',tipo='text',nome='FINALIDADE DO DOCUMENTO',valor='',largura='470',mascara='',site='1',ordenacao='11',obrigatorio='0'
						WHERE id_servico_campo='578';
--26/05/2011 12:56:14
DELETE FROM vsites_servico_campo WHERE id_servico_campo = '' AND id_servico='3';
--26/05/2011 12:56:25
UPDATE vsites_servico SET dias='', status='Ativo', descricao='Nascimento', site='1',desc_site='Certidão de Nasciemento',servico_desc='',site_menu='1' WHERE id_servico='2';
--26/05/2011 12:56:25
UPDATE vsites_servico_campo SET campo='certidao_nome',tipo='text',nome='NOME',valor='',largura='470',mascara='',site='1',ordenacao='1',obrigatorio='1'
						WHERE id_servico_campo='785';
--26/05/2011 12:56:25
UPDATE vsites_servico_campo SET campo='certidao_pai',tipo='text',nome='PAI',valor='',largura='470',mascara='',site='1',ordenacao='2',obrigatorio='0'
						WHERE id_servico_campo='921';
--26/05/2011 12:56:25
UPDATE vsites_servico_campo SET campo='certidao_mae',tipo='text',nome='MAE',valor='',largura='470',mascara='',site='1',ordenacao='3',obrigatorio='1'
						WHERE id_servico_campo='655';
--26/05/2011 12:56:25
UPDATE vsites_servico_campo SET campo='certidao_data_nascimento',tipo='text',nome='DATA DE NASCIMENTO',valor='',largura='470',mascara='',site='1',ordenacao='4',obrigatorio='1'
						WHERE id_servico_campo='404';
--26/05/2011 12:56:25
UPDATE vsites_servico_campo SET campo='certidao_livro',tipo='text',nome='LIVRO',valor='',largura='470',mascara='',site='1',ordenacao='5',obrigatorio='0'
						WHERE id_servico_campo='627';
--26/05/2011 12:56:25
UPDATE vsites_servico_campo SET campo='certidao_folha',tipo='text',nome='FOLHA',valor='',largura='470',mascara='',site='1',ordenacao='6',obrigatorio='0'
						WHERE id_servico_campo='605';
--26/05/2011 12:56:25
UPDATE vsites_servico_campo SET campo='certidao_registro',tipo='text',nome='REGISTRO',valor='',largura='470',mascara='',site='1',ordenacao='7',obrigatorio='0'
						WHERE id_servico_campo='1050';
--26/05/2011 12:56:25
UPDATE vsites_servico_campo SET campo='certidao_estado',tipo='text',nome='ESTADO',valor='',largura='470',mascara='',site='1',ordenacao='8',obrigatorio='1'
						WHERE id_servico_campo='527';
--26/05/2011 12:56:25
UPDATE vsites_servico_campo SET campo='certidao_cidade',tipo='text',nome='CIDADE',valor='',largura='470',mascara='',site='1',ordenacao='9',obrigatorio='1'
						WHERE id_servico_campo='163';
--26/05/2011 12:56:25
UPDATE vsites_servico_campo SET campo='certidao_cartorio',tipo='text',nome='CARTORIO',valor='',largura='470',mascara='',site='1',ordenacao='10',obrigatorio='0'
						WHERE id_servico_campo='54';
--26/05/2011 12:56:25
UPDATE vsites_servico_campo SET campo='certidao_cartorio_cep',tipo='text',nome='CEP DO CARTORIO',valor='',largura='470',mascara='',site='1',ordenacao='11',obrigatorio='0'
						WHERE id_servico_campo='98';
--26/05/2011 12:56:25
UPDATE vsites_servico_campo SET campo='certidao_data_registro',tipo='text',nome='DATA DO REGISTRO',valor='',largura='470',mascara='',site='1',ordenacao='12',obrigatorio='0'
						WHERE id_servico_campo='423';
--26/05/2011 12:56:25
UPDATE vsites_servico_campo SET campo='certidao_protocolo',tipo='text',nome='PROTOCOLO',valor='',largura='470',mascara='',site='0',ordenacao='13',obrigatorio='0'
						WHERE id_servico_campo='1001';
--26/05/2011 12:56:25
UPDATE vsites_servico_campo SET campo='certidao_averbacao',tipo='text',nome='AVERBACAO',valor='',largura='470',mascara='',site='1',ordenacao='14',obrigatorio='0'
						WHERE id_servico_campo='11';
--26/05/2011 12:56:25
UPDATE vsites_servico_campo SET campo='certidao_finalidade',tipo='text',nome='FINALIDADE DO DOCUMENTO',valor='',largura='470',mascara='',site='1',ordenacao='15',obrigatorio='0'
						WHERE id_servico_campo='584';
--26/05/2011 12:56:25
UPDATE vsites_servico_campo SET campo='certidao_tem_copia_doc',tipo='text',nome='TEM COPIA DO DOCUMENTO',valor='',largura='470',mascara='',site='1',ordenacao='16',obrigatorio='0'
						WHERE id_servico_campo='1228';
--26/05/2011 12:56:25
DELETE FROM vsites_servico_campo WHERE id_servico_campo = '' AND id_servico='2';
--26/05/2011 12:56:30
UPDATE vsites_servico SET dias='', status='Ativo', descricao='Nascimento', site='1',desc_site='Certidão de Nascimento',servico_desc='',site_menu='1' WHERE id_servico='2';
--26/05/2011 12:56:30
UPDATE vsites_servico_campo SET campo='certidao_nome',tipo='text',nome='NOME',valor='',largura='470',mascara='',site='1',ordenacao='1',obrigatorio='1'
						WHERE id_servico_campo='785';
--26/05/2011 12:56:30
UPDATE vsites_servico_campo SET campo='certidao_pai',tipo='text',nome='PAI',valor='',largura='470',mascara='',site='1',ordenacao='2',obrigatorio='0'
						WHERE id_servico_campo='921';
--26/05/2011 12:56:30
UPDATE vsites_servico_campo SET campo='certidao_mae',tipo='text',nome='MAE',valor='',largura='470',mascara='',site='1',ordenacao='3',obrigatorio='1'
						WHERE id_servico_campo='655';
--26/05/2011 12:56:30
UPDATE vsites_servico_campo SET campo='certidao_data_nascimento',tipo='text',nome='DATA DE NASCIMENTO',valor='',largura='470',mascara='',site='1',ordenacao='4',obrigatorio='1'
						WHERE id_servico_campo='404';
--26/05/2011 12:56:30
UPDATE vsites_servico_campo SET campo='certidao_livro',tipo='text',nome='LIVRO',valor='',largura='470',mascara='',site='1',ordenacao='5',obrigatorio='0'
						WHERE id_servico_campo='627';
--26/05/2011 12:56:30
UPDATE vsites_servico_campo SET campo='certidao_folha',tipo='text',nome='FOLHA',valor='',largura='470',mascara='',site='1',ordenacao='6',obrigatorio='0'
						WHERE id_servico_campo='605';
--26/05/2011 12:56:30
UPDATE vsites_servico_campo SET campo='certidao_registro',tipo='text',nome='REGISTRO',valor='',largura='470',mascara='',site='1',ordenacao='7',obrigatorio='0'
						WHERE id_servico_campo='1050';
--26/05/2011 12:56:30
UPDATE vsites_servico_campo SET campo='certidao_estado',tipo='text',nome='ESTADO',valor='',largura='470',mascara='',site='1',ordenacao='8',obrigatorio='1'
						WHERE id_servico_campo='527';
--26/05/2011 12:56:30
UPDATE vsites_servico_campo SET campo='certidao_cidade',tipo='text',nome='CIDADE',valor='',largura='470',mascara='',site='1',ordenacao='9',obrigatorio='1'
						WHERE id_servico_campo='163';
--26/05/2011 12:56:30
UPDATE vsites_servico_campo SET campo='certidao_cartorio',tipo='text',nome='CARTORIO',valor='',largura='470',mascara='',site='1',ordenacao='10',obrigatorio='0'
						WHERE id_servico_campo='54';
--26/05/2011 12:56:30
UPDATE vsites_servico_campo SET campo='certidao_cartorio_cep',tipo='text',nome='CEP DO CARTORIO',valor='',largura='470',mascara='',site='1',ordenacao='11',obrigatorio='0'
						WHERE id_servico_campo='98';
--26/05/2011 12:56:30
UPDATE vsites_servico_campo SET campo='certidao_data_registro',tipo='text',nome='DATA DO REGISTRO',valor='',largura='470',mascara='',site='1',ordenacao='12',obrigatorio='0'
						WHERE id_servico_campo='423';
--26/05/2011 12:56:30
UPDATE vsites_servico_campo SET campo='certidao_protocolo',tipo='text',nome='PROTOCOLO',valor='',largura='470',mascara='',site='0',ordenacao='13',obrigatorio='0'
						WHERE id_servico_campo='1001';
--26/05/2011 12:56:30
UPDATE vsites_servico_campo SET campo='certidao_averbacao',tipo='text',nome='AVERBACAO',valor='',largura='470',mascara='',site='1',ordenacao='14',obrigatorio='0'
						WHERE id_servico_campo='11';
--26/05/2011 12:56:30
UPDATE vsites_servico_campo SET campo='certidao_finalidade',tipo='text',nome='FINALIDADE DO DOCUMENTO',valor='',largura='470',mascara='',site='1',ordenacao='15',obrigatorio='0'
						WHERE id_servico_campo='584';
--26/05/2011 12:56:30
UPDATE vsites_servico_campo SET campo='certidao_tem_copia_doc',tipo='text',nome='TEM COPIA DO DOCUMENTO',valor='',largura='470',mascara='',site='1',ordenacao='16',obrigatorio='0'
						WHERE id_servico_campo='1228';
--26/05/2011 12:56:30
DELETE FROM vsites_servico_campo WHERE id_servico_campo = '' AND id_servico='2';
--26/05/2011 13:01:47
UPDATE vsites_servico SET dias='', status='Ativo', descricao='Nascimento', site='1',desc_site='Certidão de Nascimento (2ª)',servico_desc='',site_menu='1' WHERE id_servico='2';
--26/05/2011 13:01:47
UPDATE vsites_servico_campo SET campo='certidao_nome',tipo='text',nome='NOME',valor='',largura='470',mascara='',site='1',ordenacao='1',obrigatorio='1'
						WHERE id_servico_campo='785';
--26/05/2011 13:01:47
UPDATE vsites_servico_campo SET campo='certidao_pai',tipo='text',nome='PAI',valor='',largura='470',mascara='',site='1',ordenacao='2',obrigatorio='0'
						WHERE id_servico_campo='921';
--26/05/2011 13:01:47
UPDATE vsites_servico_campo SET campo='certidao_mae',tipo='text',nome='MAE',valor='',largura='470',mascara='',site='1',ordenacao='3',obrigatorio='1'
						WHERE id_servico_campo='655';
--26/05/2011 13:01:47
UPDATE vsites_servico_campo SET campo='certidao_data_nascimento',tipo='text',nome='DATA DE NASCIMENTO',valor='',largura='470',mascara='',site='1',ordenacao='4',obrigatorio='1'
						WHERE id_servico_campo='404';
--26/05/2011 13:01:47
UPDATE vsites_servico_campo SET campo='certidao_livro',tipo='text',nome='LIVRO',valor='',largura='470',mascara='',site='1',ordenacao='5',obrigatorio='0'
						WHERE id_servico_campo='627';
--26/05/2011 13:01:47
UPDATE vsites_servico_campo SET campo='certidao_folha',tipo='text',nome='FOLHA',valor='',largura='470',mascara='',site='1',ordenacao='6',obrigatorio='0'
						WHERE id_servico_campo='605';
--26/05/2011 13:01:47
UPDATE vsites_servico_campo SET campo='certidao_registro',tipo='text',nome='REGISTRO',valor='',largura='470',mascara='',site='1',ordenacao='7',obrigatorio='0'
						WHERE id_servico_campo='1050';
--26/05/2011 13:01:47
UPDATE vsites_servico_campo SET campo='certidao_estado',tipo='text',nome='ESTADO',valor='',largura='470',mascara='',site='1',ordenacao='8',obrigatorio='1'
						WHERE id_servico_campo='527';
--26/05/2011 13:01:47
UPDATE vsites_servico_campo SET campo='certidao_cidade',tipo='text',nome='CIDADE',valor='',largura='470',mascara='',site='1',ordenacao='9',obrigatorio='1'
						WHERE id_servico_campo='163';
--26/05/2011 13:01:47
UPDATE vsites_servico_campo SET campo='certidao_cartorio',tipo='text',nome='CARTORIO',valor='',largura='470',mascara='',site='1',ordenacao='10',obrigatorio='0'
						WHERE id_servico_campo='54';
--26/05/2011 13:01:47
UPDATE vsites_servico_campo SET campo='certidao_cartorio_cep',tipo='text',nome='CEP DO CARTORIO',valor='',largura='470',mascara='',site='1',ordenacao='11',obrigatorio='0'
						WHERE id_servico_campo='98';
--26/05/2011 13:01:47
UPDATE vsites_servico_campo SET campo='certidao_data_registro',tipo='text',nome='DATA DO REGISTRO',valor='',largura='470',mascara='',site='1',ordenacao='12',obrigatorio='0'
						WHERE id_servico_campo='423';
--26/05/2011 13:01:47
UPDATE vsites_servico_campo SET campo='certidao_protocolo',tipo='text',nome='PROTOCOLO',valor='',largura='470',mascara='',site='0',ordenacao='13',obrigatorio='0'
						WHERE id_servico_campo='1001';
--26/05/2011 13:01:47
UPDATE vsites_servico_campo SET campo='certidao_averbacao',tipo='text',nome='AVERBACAO',valor='',largura='470',mascara='',site='1',ordenacao='14',obrigatorio='0'
						WHERE id_servico_campo='11';
--26/05/2011 13:01:47
UPDATE vsites_servico_campo SET campo='certidao_finalidade',tipo='text',nome='FINALIDADE DO DOCUMENTO',valor='',largura='470',mascara='',site='1',ordenacao='15',obrigatorio='0'
						WHERE id_servico_campo='584';
--26/05/2011 13:01:47
UPDATE vsites_servico_campo SET campo='certidao_tem_copia_doc',tipo='text',nome='TEM COPIA DO DOCUMENTO',valor='',largura='470',mascara='',site='1',ordenacao='16',obrigatorio='0'
						WHERE id_servico_campo='1228';
--26/05/2011 13:01:47
DELETE FROM vsites_servico_campo WHERE id_servico_campo = '' AND id_servico='2';
--26/05/2011 13:01:51
UPDATE vsites_servico SET dias='', status='Ativo', descricao='Nascimento', site='1',desc_site='Certidão de Nascimento (2ª via)',servico_desc='',site_menu='1' WHERE id_servico='2';
--26/05/2011 13:01:51
UPDATE vsites_servico_campo SET campo='certidao_nome',tipo='text',nome='NOME',valor='',largura='470',mascara='',site='1',ordenacao='1',obrigatorio='1'
						WHERE id_servico_campo='785';
--26/05/2011 13:01:51
UPDATE vsites_servico_campo SET campo='certidao_pai',tipo='text',nome='PAI',valor='',largura='470',mascara='',site='1',ordenacao='2',obrigatorio='0'
						WHERE id_servico_campo='921';
--26/05/2011 13:01:51
UPDATE vsites_servico_campo SET campo='certidao_mae',tipo='text',nome='MAE',valor='',largura='470',mascara='',site='1',ordenacao='3',obrigatorio='1'
						WHERE id_servico_campo='655';
--26/05/2011 13:01:51
UPDATE vsites_servico_campo SET campo='certidao_data_nascimento',tipo='text',nome='DATA DE NASCIMENTO',valor='',largura='470',mascara='',site='1',ordenacao='4',obrigatorio='1'
						WHERE id_servico_campo='404';
--26/05/2011 13:01:51
UPDATE vsites_servico_campo SET campo='certidao_livro',tipo='text',nome='LIVRO',valor='',largura='470',mascara='',site='1',ordenacao='5',obrigatorio='0'
						WHERE id_servico_campo='627';
--26/05/2011 13:01:51
UPDATE vsites_servico_campo SET campo='certidao_folha',tipo='text',nome='FOLHA',valor='',largura='470',mascara='',site='1',ordenacao='6',obrigatorio='0'
						WHERE id_servico_campo='605';
--26/05/2011 13:01:51
UPDATE vsites_servico_campo SET campo='certidao_registro',tipo='text',nome='REGISTRO',valor='',largura='470',mascara='',site='1',ordenacao='7',obrigatorio='0'
						WHERE id_servico_campo='1050';
--26/05/2011 13:01:51
UPDATE vsites_servico_campo SET campo='certidao_estado',tipo='text',nome='ESTADO',valor='',largura='470',mascara='',site='1',ordenacao='8',obrigatorio='1'
						WHERE id_servico_campo='527';
--26/05/2011 13:01:51
UPDATE vsites_servico_campo SET campo='certidao_cidade',tipo='text',nome='CIDADE',valor='',largura='470',mascara='',site='1',ordenacao='9',obrigatorio='1'
						WHERE id_servico_campo='163';
--26/05/2011 13:01:51
UPDATE vsites_servico_campo SET campo='certidao_cartorio',tipo='text',nome='CARTORIO',valor='',largura='470',mascara='',site='1',ordenacao='10',obrigatorio='0'
						WHERE id_servico_campo='54';
--26/05/2011 13:01:51
UPDATE vsites_servico_campo SET campo='certidao_cartorio_cep',tipo='text',nome='CEP DO CARTORIO',valor='',largura='470',mascara='',site='1',ordenacao='11',obrigatorio='0'
						WHERE id_servico_campo='98';
--26/05/2011 13:01:51
UPDATE vsites_servico_campo SET campo='certidao_data_registro',tipo='text',nome='DATA DO REGISTRO',valor='',largura='470',mascara='',site='1',ordenacao='12',obrigatorio='0'
						WHERE id_servico_campo='423';
--26/05/2011 13:01:51
UPDATE vsites_servico_campo SET campo='certidao_protocolo',tipo='text',nome='PROTOCOLO',valor='',largura='470',mascara='',site='0',ordenacao='13',obrigatorio='0'
						WHERE id_servico_campo='1001';
--26/05/2011 13:01:51
UPDATE vsites_servico_campo SET campo='certidao_averbacao',tipo='text',nome='AVERBACAO',valor='',largura='470',mascara='',site='1',ordenacao='14',obrigatorio='0'
						WHERE id_servico_campo='11';
--26/05/2011 13:01:51
UPDATE vsites_servico_campo SET campo='certidao_finalidade',tipo='text',nome='FINALIDADE DO DOCUMENTO',valor='',largura='470',mascara='',site='1',ordenacao='15',obrigatorio='0'
						WHERE id_servico_campo='584';
--26/05/2011 13:01:51
UPDATE vsites_servico_campo SET campo='certidao_tem_copia_doc',tipo='text',nome='TEM COPIA DO DOCUMENTO',valor='',largura='470',mascara='',site='1',ordenacao='16',obrigatorio='0'
						WHERE id_servico_campo='1228';
--26/05/2011 13:01:51
DELETE FROM vsites_servico_campo WHERE id_servico_campo = '' AND id_servico='2';
--26/05/2011 17:28:56
UPDATE vsites_servico SET dias='', status='Ativo', descricao='Anotação - Óbito', site='',desc_site='',servico_desc='',site_menu='' WHERE id_servico='30';
--26/05/2011 17:28:56
UPDATE vsites_servico_campo SET campo='certidao_nome',tipo='text',nome='NOME',valor='',largura='470',mascara='',site='1',ordenacao='1',obrigatorio='1'
						WHERE id_servico_campo='728';
--26/05/2011 17:28:56
UPDATE vsites_servico_campo SET campo='certidao_conjuge',tipo='text',nome='CONJUGE',valor='',largura='470',mascara='',site='1',ordenacao='2',obrigatorio='0'
						WHERE id_servico_campo='272';
--26/05/2011 17:28:56
UPDATE vsites_servico_campo SET campo='certidao_pai',tipo='text',nome='PAI',valor='',largura='470',mascara='',site='1',ordenacao='3',obrigatorio='0'
						WHERE id_servico_campo='904';
--26/05/2011 17:28:57
UPDATE vsites_servico_campo SET campo='certidao_mae',tipo='text',nome='MAE',valor='',largura='470',mascara='',site='1',ordenacao='4',obrigatorio='0'
						WHERE id_servico_campo='638';
--26/05/2011 17:28:57
UPDATE vsites_servico_campo SET campo='certidao_data_casamento',tipo='text',nome='DATA DE CASAMENTO',valor='',largura='470',mascara='',site='1',ordenacao='5',obrigatorio='0'
						WHERE id_servico_campo='369';
--26/05/2011 17:28:57
UPDATE vsites_servico_campo SET campo='certidao_data_nascimento',tipo='text',nome='DATA DE NASCIMENTO',valor='',largura='470',mascara='',site='1',ordenacao='6',obrigatorio='0'
						WHERE id_servico_campo='1504';
--26/05/2011 17:28:57
UPDATE vsites_servico_campo SET campo='certidao_livro',tipo='text',nome='LIVRO',valor='',largura='470',mascara='',site='1',ordenacao='7',obrigatorio='0'
						WHERE id_servico_campo='616';
--26/05/2011 17:28:57
UPDATE vsites_servico_campo SET campo='certidao_folha',tipo='text',nome='FOLHA',valor='',largura='470',mascara='',site='1',ordenacao='8',obrigatorio='0'
						WHERE id_servico_campo='592';
--26/05/2011 17:28:57
UPDATE vsites_servico_campo SET campo='certidao_registro',tipo='text',nome='REGISTRO',valor='',largura='470',mascara='',site='1',ordenacao='9',obrigatorio='0'
						WHERE id_servico_campo='1041';
--26/05/2011 17:28:57
UPDATE vsites_servico_campo SET campo='certidao_estado',tipo='text',nome='ESTADO',valor='',largura='470',mascara='',site='1',ordenacao='10',obrigatorio='1'
						WHERE id_servico_campo='471';
--26/05/2011 17:28:57
UPDATE vsites_servico_campo SET campo='certidao_cidade',tipo='text',nome='CIDADE',valor='',largura='470',mascara='',site='1',ordenacao='11',obrigatorio='1'
						WHERE id_servico_campo='105';
--26/05/2011 17:28:57
UPDATE vsites_servico_campo SET campo='certidao_cartorio',tipo='text',nome='CARTÓRIO',valor='',largura='470',mascara='',site='1',ordenacao='12',obrigatorio='0'
						WHERE id_servico_campo='82';
--26/05/2011 17:28:57
UPDATE vsites_servico_campo SET campo='certidao_averbacao',tipo='text',nome='AVERBACAO',valor='',largura='470',mascara='',site='1',ordenacao='13',obrigatorio='0'
						WHERE id_servico_campo='2';
--26/05/2011 17:28:57
UPDATE vsites_servico_campo SET campo='certidao_finalidade',tipo='text',nome='FINALIDADE DO DOCUMENTO',valor='',largura='470',mascara='',site='1',ordenacao='14',obrigatorio='0'
						WHERE id_servico_campo='574';
--26/05/2011 17:28:57
UPDATE vsites_servico_campo SET campo='certidao_data_registro',tipo='text',nome='DATA DE REGISTRO',valor='',largura='470',mascara='',site='1',ordenacao='15',obrigatorio='0'
						WHERE id_servico_campo='1603';
--26/05/2011 17:28:57
DELETE FROM vsites_servico_campo WHERE id_servico_campo = '' AND id_servico='30';
--26/05/2011 17:29:11
UPDATE vsites_servico SET dias='', status='Ativo', descricao='Casamento', site='1',desc_site='Certidão de Casamento (2ª via)',servico_desc='',site_menu='1' WHERE id_servico='3';
--26/05/2011 17:29:11
UPDATE vsites_servico_campo SET campo='certidao_nome',tipo='text',nome='NOME',valor='',largura='470',mascara='',site='1',ordenacao='1',obrigatorio='1'
						WHERE id_servico_campo='745';
--26/05/2011 17:29:11
UPDATE vsites_servico_campo SET campo='certidao_esposa',tipo='text',nome='ESPOSA/ESPOSO',valor='',largura='470',mascara='',site='1',ordenacao='2',obrigatorio='1'
						WHERE id_servico_campo='464';
--26/05/2011 17:29:11
UPDATE vsites_servico_campo SET campo='certidao_data_casamento',tipo='text',nome='DATA DE CASAMENTO',valor='',largura='470',mascara='',site='1',ordenacao='3',obrigatorio='1'
						WHERE id_servico_campo='364';
--26/05/2011 17:29:11
UPDATE vsites_servico_campo SET campo='certidao_livro',tipo='text',nome='LIVRO',valor='',largura='470',mascara='',site='1',ordenacao='4',obrigatorio='0'
						WHERE id_servico_campo='619';
--26/05/2011 17:29:11
UPDATE vsites_servico_campo SET campo='certidao_folha',tipo='text',nome='FOLHA',valor='',largura='470',mascara='',site='1',ordenacao='5',obrigatorio='0'
						WHERE id_servico_campo='596';
--26/05/2011 17:29:11
UPDATE vsites_servico_campo SET campo='certidao_registro',tipo='text',nome='REGISTRO',valor='',largura='470',mascara='',site='1',ordenacao='6',obrigatorio='0'
						WHERE id_servico_campo='1044';
--26/05/2011 17:29:11
UPDATE vsites_servico_campo SET campo='certidao_estado',tipo='text',nome='ESTADO',valor='',largura='470',mascara='',site='1',ordenacao='7',obrigatorio='1'
						WHERE id_servico_campo='488';
--26/05/2011 17:29:11
UPDATE vsites_servico_campo SET campo='certidao_cidade',tipo='text',nome='CIDADE',valor='',largura='470',mascara='',site='1',ordenacao='8',obrigatorio='1'
						WHERE id_servico_campo='122';
--26/05/2011 17:29:11
UPDATE vsites_servico_campo SET campo='certidao_averbacao',tipo='text',nome='AVERBACAO',valor='',largura='470',mascara='',site='1',ordenacao='9',obrigatorio='0'
						WHERE id_servico_campo='5';
--26/05/2011 17:29:11
UPDATE vsites_servico_campo SET campo='certidao_cartorio',tipo='text',nome='CARTORIO',valor='',largura='470',mascara='',site='1',ordenacao='10',obrigatorio='0'
						WHERE id_servico_campo='34';
--26/05/2011 17:29:11
UPDATE vsites_servico_campo SET campo='certidao_finalidade',tipo='text',nome='FINALIDADE DO DOCUMENTO',valor='',largura='470',mascara='',site='1',ordenacao='11',obrigatorio='0'
						WHERE id_servico_campo='578';
--26/05/2011 17:29:11
DELETE FROM vsites_servico_campo WHERE id_servico_campo = '' AND id_servico='3';
--26/05/2011 17:29:31
UPDATE vsites_servico SET dias='', status='Ativo', descricao='Óbito', site='1',desc_site='Certidão de Óbito (2ª via)',servico_desc='',site_menu='' WHERE id_servico='4';
--26/05/2011 17:29:31
UPDATE vsites_servico_campo SET campo='certidao_nome',tipo='text',nome='NOME',valor='',largura='470',mascara='',site='1',ordenacao='1',obrigatorio='1'
						WHERE id_servico_campo='791';
--26/05/2011 17:29:31
UPDATE vsites_servico_campo SET campo='certidao_mae',tipo='text',nome='MAE',valor='',largura='470',mascara='',site='1',ordenacao='2',obrigatorio='0'
						WHERE id_servico_campo='657';
--26/05/2011 17:29:31
UPDATE vsites_servico_campo SET campo='certidao_pai',tipo='text',nome='PAI',valor='',largura='470',mascara='',site='1',ordenacao='3',obrigatorio='0'
						WHERE id_servico_campo='923';
--26/05/2011 17:29:31
UPDATE vsites_servico_campo SET campo='certidao_data_obito',tipo='text',nome='DATA DE OBITO',valor='',largura='470',mascara='',site='1',ordenacao='4',obrigatorio='1'
						WHERE id_servico_campo='413';
--26/05/2011 17:29:31
UPDATE vsites_servico_campo SET campo='certidao_livro',tipo='text',nome='LIVRO',valor='',largura='470',mascara='',site='1',ordenacao='5',obrigatorio='0'
						WHERE id_servico_campo='629';
--26/05/2011 17:29:31
UPDATE vsites_servico_campo SET campo='certidao_folha',tipo='text',nome='FOLHA',valor='',largura='470',mascara='',site='1',ordenacao='6',obrigatorio='0'
						WHERE id_servico_campo='607';
--26/05/2011 17:29:31
UPDATE vsites_servico_campo SET campo='certidao_termo',tipo='text',nome='TERMO',valor='',largura='470',mascara='',site='1',ordenacao='7',obrigatorio='0'
						WHERE id_servico_campo='1230';
--26/05/2011 17:29:31
UPDATE vsites_servico_campo SET campo='certidao_estado',tipo='text',nome='ESTADO',valor='',largura='470',mascara='',site='1',ordenacao='8',obrigatorio='1'
						WHERE id_servico_campo='533';
--26/05/2011 17:29:31
UPDATE vsites_servico_campo SET campo='certidao_cidade',tipo='text',nome='CIDADE',valor='',largura='470',mascara='',site='1',ordenacao='9',obrigatorio='1'
						WHERE id_servico_campo='169';
--26/05/2011 17:29:31
UPDATE vsites_servico_campo SET campo='certidao_cartorio',tipo='text',nome='CARTORIO',valor='',largura='470',mascara='',site='1',ordenacao='10',obrigatorio='0'
						WHERE id_servico_campo='59';
--26/05/2011 17:29:31
UPDATE vsites_servico_campo SET campo='certidao_cartorio_endereco',tipo='text',nome='ENDERECO DO CARTORIO',valor='',largura='470',mascara='',site='1',ordenacao='11',obrigatorio='0'
						WHERE id_servico_campo='460';
--26/05/2011 17:29:31
UPDATE vsites_servico_campo SET campo='certidao_registro',tipo='text',nome='REGISTRO',valor='',largura='470',mascara='',site='1',ordenacao='12',obrigatorio='0'
						WHERE id_servico_campo='1052';
--26/05/2011 17:29:31
UPDATE vsites_servico_campo SET campo='certidao_data_registro',tipo='text',nome='DATA DO REGISTRO',valor='',largura='470',mascara='',site='1',ordenacao='13',obrigatorio='0'
						WHERE id_servico_campo='425';
--26/05/2011 17:29:31
UPDATE vsites_servico_campo SET campo='certidao_protocolo',tipo='text',nome='PROTOCOLO',valor='',largura='470',mascara='',site='0',ordenacao='14',obrigatorio='0'
						WHERE id_servico_campo='1007';
--26/05/2011 17:29:31
UPDATE vsites_servico_campo SET campo='certidao_finalidade',tipo='text',nome='FINALIDADE DO DOCUMENTO',valor='',largura='470',mascara='',site='1',ordenacao='15',obrigatorio='0'
						WHERE id_servico_campo='586';
--26/05/2011 17:29:31
UPDATE vsites_servico_campo SET campo='certidao_averbacao',tipo='text',nome='AVERBACAO',valor='',largura='470',mascara='',site='1',ordenacao='16',obrigatorio='0'
						WHERE id_servico_campo='13';
--26/05/2011 17:29:31
DELETE FROM vsites_servico_campo WHERE id_servico_campo = '' AND id_servico='4';
--26/05/2011 17:29:37
UPDATE vsites_servico SET dias='', status='Ativo', descricao='Óbito', site='1',desc_site='Certidão de Óbito (2ª via)',servico_desc='',site_menu='1' WHERE id_servico='4';
--26/05/2011 17:29:37
UPDATE vsites_servico_campo SET campo='certidao_nome',tipo='text',nome='NOME',valor='',largura='470',mascara='',site='1',ordenacao='1',obrigatorio='1'
						WHERE id_servico_campo='791';
--26/05/2011 17:29:37
UPDATE vsites_servico_campo SET campo='certidao_mae',tipo='text',nome='MAE',valor='',largura='470',mascara='',site='1',ordenacao='2',obrigatorio='0'
						WHERE id_servico_campo='657';
--26/05/2011 17:29:37
UPDATE vsites_servico_campo SET campo='certidao_pai',tipo='text',nome='PAI',valor='',largura='470',mascara='',site='1',ordenacao='3',obrigatorio='0'
						WHERE id_servico_campo='923';
--26/05/2011 17:29:37
UPDATE vsites_servico_campo SET campo='certidao_data_obito',tipo='text',nome='DATA DE OBITO',valor='',largura='470',mascara='',site='1',ordenacao='4',obrigatorio='1'
						WHERE id_servico_campo='413';
--26/05/2011 17:29:37
UPDATE vsites_servico_campo SET campo='certidao_livro',tipo='text',nome='LIVRO',valor='',largura='470',mascara='',site='1',ordenacao='5',obrigatorio='0'
						WHERE id_servico_campo='629';
--26/05/2011 17:29:37
UPDATE vsites_servico_campo SET campo='certidao_folha',tipo='text',nome='FOLHA',valor='',largura='470',mascara='',site='1',ordenacao='6',obrigatorio='0'
						WHERE id_servico_campo='607';
--26/05/2011 17:29:37
UPDATE vsites_servico_campo SET campo='certidao_termo',tipo='text',nome='TERMO',valor='',largura='470',mascara='',site='1',ordenacao='7',obrigatorio='0'
						WHERE id_servico_campo='1230';
--26/05/2011 17:29:37
UPDATE vsites_servico_campo SET campo='certidao_estado',tipo='text',nome='ESTADO',valor='',largura='470',mascara='',site='1',ordenacao='8',obrigatorio='1'
						WHERE id_servico_campo='533';
--26/05/2011 17:29:37
UPDATE vsites_servico_campo SET campo='certidao_cidade',tipo='text',nome='CIDADE',valor='',largura='470',mascara='',site='1',ordenacao='9',obrigatorio='1'
						WHERE id_servico_campo='169';
--26/05/2011 17:29:37
UPDATE vsites_servico_campo SET campo='certidao_cartorio',tipo='text',nome='CARTORIO',valor='',largura='470',mascara='',site='1',ordenacao='10',obrigatorio='0'
						WHERE id_servico_campo='59';
--26/05/2011 17:29:37
UPDATE vsites_servico_campo SET campo='certidao_cartorio_endereco',tipo='text',nome='ENDERECO DO CARTORIO',valor='',largura='470',mascara='',site='1',ordenacao='11',obrigatorio='0'
						WHERE id_servico_campo='460';
--26/05/2011 17:29:37
UPDATE vsites_servico_campo SET campo='certidao_registro',tipo='text',nome='REGISTRO',valor='',largura='470',mascara='',site='1',ordenacao='12',obrigatorio='0'
						WHERE id_servico_campo='1052';
--26/05/2011 17:29:37
UPDATE vsites_servico_campo SET campo='certidao_data_registro',tipo='text',nome='DATA DO REGISTRO',valor='',largura='470',mascara='',site='1',ordenacao='13',obrigatorio='0'
						WHERE id_servico_campo='425';
--26/05/2011 17:29:37
UPDATE vsites_servico_campo SET campo='certidao_protocolo',tipo='text',nome='PROTOCOLO',valor='',largura='470',mascara='',site='0',ordenacao='14',obrigatorio='0'
						WHERE id_servico_campo='1007';
--26/05/2011 17:29:37
UPDATE vsites_servico_campo SET campo='certidao_finalidade',tipo='text',nome='FINALIDADE DO DOCUMENTO',valor='',largura='470',mascara='',site='1',ordenacao='15',obrigatorio='0'
						WHERE id_servico_campo='586';
--26/05/2011 17:29:37
UPDATE vsites_servico_campo SET campo='certidao_averbacao',tipo='text',nome='AVERBACAO',valor='',largura='470',mascara='',site='1',ordenacao='16',obrigatorio='0'
						WHERE id_servico_campo='13';
--26/05/2011 17:29:37
DELETE FROM vsites_servico_campo WHERE id_servico_campo = '' AND id_servico='4';
--26/05/2011 17:30:03
UPDATE vsites_servico SET dias='', status='Ativo', descricao='Negativa de Protesto', site='1',desc_site='Certidão Negativa de Protesto',servico_desc='',site_menu='' WHERE id_servico='5';
--26/05/2011 17:30:03
UPDATE vsites_servico_campo SET campo='certidao_nome',tipo='text',nome='NOME',valor='',largura='470',mascara='',site='1',ordenacao='1',obrigatorio='1'
						WHERE id_servico_campo='787';
--26/05/2011 17:30:03
UPDATE vsites_servico_campo SET campo='certidao_rg',tipo='text',nome='RG',valor='',largura='470',mascara='',site='1',ordenacao='2',obrigatorio='0'
						WHERE id_servico_campo='1184';
--26/05/2011 17:30:03
UPDATE vsites_servico_campo SET campo='certidao_cpf',tipo='text',nome='CPF',valor='',largura='470',mascara='',site='1',ordenacao='3',obrigatorio='0'
						WHERE id_servico_campo='329';
--26/05/2011 17:30:03
UPDATE vsites_servico_campo SET campo='certidao_cnpj',tipo='text',nome='CNPJ',valor='',largura='470',mascara='',site='1',ordenacao='4',obrigatorio='0'
						WHERE id_servico_campo='243';
--26/05/2011 17:30:03
UPDATE vsites_servico_campo SET campo='certidao_estado',tipo='text',nome='ESTADO',valor='',largura='470',mascara='',site='1',ordenacao='5',obrigatorio='1'
						WHERE id_servico_campo='529';
--26/05/2011 17:30:03
UPDATE vsites_servico_campo SET campo='certidao_cidade',tipo='text',nome='CIDADE',valor='',largura='470',mascara='',site='1',ordenacao='6',obrigatorio='1'
						WHERE id_servico_campo='165';
--26/05/2011 17:30:03
UPDATE vsites_servico_campo SET campo='certidao_comarca_forum',tipo='text',nome='COMARCA',valor='',largura='470',mascara='',site='1',ordenacao='7',obrigatorio='0'
						WHERE id_servico_campo='1675';
--26/05/2011 17:30:03
UPDATE vsites_servico_campo SET campo='certidao_cartorio',tipo='text',nome='CARTORIO',valor='',largura='470',mascara='',site='1',ordenacao='8',obrigatorio='0'
						WHERE id_servico_campo='56';
--26/05/2011 17:30:03
UPDATE vsites_servico_campo SET campo='certidao_qtdd_cartorio',tipo='text',nome='NUMERO DO CARTORIO',valor='',largura='470',mascara='',site='1',ordenacao='9',obrigatorio='1'
						WHERE id_servico_campo='1596';
--26/05/2011 17:30:03
DELETE FROM vsites_servico_campo WHERE id_servico_campo = '' AND id_servico='5';
--26/05/2011 17:30:07
UPDATE vsites_servico SET dias='', status='Ativo', descricao='Negativa de Protesto', site='1',desc_site='Certidão Negativa de Protesto',servico_desc='',site_menu='1' WHERE id_servico='5';
--26/05/2011 17:30:07
UPDATE vsites_servico_campo SET campo='certidao_nome',tipo='text',nome='NOME',valor='',largura='470',mascara='',site='1',ordenacao='1',obrigatorio='1'
						WHERE id_servico_campo='787';
--26/05/2011 17:30:07
UPDATE vsites_servico_campo SET campo='certidao_rg',tipo='text',nome='RG',valor='',largura='470',mascara='',site='1',ordenacao='2',obrigatorio='0'
						WHERE id_servico_campo='1184';
--26/05/2011 17:30:07
UPDATE vsites_servico_campo SET campo='certidao_cpf',tipo='text',nome='CPF',valor='',largura='470',mascara='',site='1',ordenacao='3',obrigatorio='0'
						WHERE id_servico_campo='329';
--26/05/2011 17:30:07
UPDATE vsites_servico_campo SET campo='certidao_cnpj',tipo='text',nome='CNPJ',valor='',largura='470',mascara='',site='1',ordenacao='4',obrigatorio='0'
						WHERE id_servico_campo='243';
--26/05/2011 17:30:07
UPDATE vsites_servico_campo SET campo='certidao_estado',tipo='text',nome='ESTADO',valor='',largura='470',mascara='',site='1',ordenacao='5',obrigatorio='1'
						WHERE id_servico_campo='529';
--26/05/2011 17:30:07
UPDATE vsites_servico_campo SET campo='certidao_cidade',tipo='text',nome='CIDADE',valor='',largura='470',mascara='',site='1',ordenacao='6',obrigatorio='1'
						WHERE id_servico_campo='165';
--26/05/2011 17:30:07
UPDATE vsites_servico_campo SET campo='certidao_comarca_forum',tipo='text',nome='COMARCA',valor='',largura='470',mascara='',site='1',ordenacao='7',obrigatorio='0'
						WHERE id_servico_campo='1675';
--26/05/2011 17:30:07
UPDATE vsites_servico_campo SET campo='certidao_cartorio',tipo='text',nome='CARTORIO',valor='',largura='470',mascara='',site='1',ordenacao='8',obrigatorio='0'
						WHERE id_servico_campo='56';
--26/05/2011 17:30:07
UPDATE vsites_servico_campo SET campo='certidao_qtdd_cartorio',tipo='text',nome='NUMERO DO CARTORIO',valor='',largura='470',mascara='',site='1',ordenacao='9',obrigatorio='1'
						WHERE id_servico_campo='1596';
--26/05/2011 17:30:07
DELETE FROM vsites_servico_campo WHERE id_servico_campo = '' AND id_servico='5';
--26/05/2011 17:30:38
UPDATE vsites_servico SET dias='', status='Ativo', descricao='Distribuidor Civel', site='1',desc_site='Certidão de Distribuidor Civel',servico_desc='',site_menu='1' WHERE id_servico='6';
--26/05/2011 17:30:38
UPDATE vsites_servico_campo SET campo='certidao_nome',tipo='text',nome='NOME',valor='',largura='470',mascara='',site='1',ordenacao='1',obrigatorio='1'
						WHERE id_servico_campo='766';
--26/05/2011 17:30:38
UPDATE vsites_servico_campo SET campo='certidao_rg',tipo='text',nome='RG',valor='',largura='470',mascara='',site='1',ordenacao='2',obrigatorio='0'
						WHERE id_servico_campo='1164';
--26/05/2011 17:30:38
UPDATE vsites_servico_campo SET campo='certidao_cpf',tipo='text',nome='CPF',valor='',largura='470',mascara='',site='1',ordenacao='3',obrigatorio='0'
						WHERE id_servico_campo='312';
--26/05/2011 17:30:38
UPDATE vsites_servico_campo SET campo='certidao_cnpj',tipo='text',nome='CNPJ',valor='',largura='470',mascara='',site='1',ordenacao='4',obrigatorio='0'
						WHERE id_servico_campo='230';
--26/05/2011 17:30:38
UPDATE vsites_servico_campo SET campo='certidao_estado',tipo='text',nome='ESTADO',valor='',largura='470',mascara='',site='1',ordenacao='5',obrigatorio='1'
						WHERE id_servico_campo='505';
--26/05/2011 17:30:38
UPDATE vsites_servico_campo SET campo='certidao_cidade',tipo='text',nome='CIDADE',valor='',largura='470',mascara='',site='1',ordenacao='6',obrigatorio='1'
						WHERE id_servico_campo='141';
--26/05/2011 17:30:38
UPDATE vsites_servico_campo SET campo='certidao_protocolo',tipo='text',nome='PROTOCOLO',valor='',largura='470',mascara='',site='0',ordenacao='7',obrigatorio='0'
						WHERE id_servico_campo='985';
--26/05/2011 17:30:38
DELETE FROM vsites_servico_campo WHERE id_servico_campo = '' AND id_servico='6';
--26/05/2011 17:31:01
UPDATE vsites_servico SET dias='', status='Ativo', descricao='Executivos Fiscais', site='1',desc_site='Certidões de Executivos Fiscais',servico_desc='',site_menu='1' WHERE id_servico='7';
--26/05/2011 17:31:01
UPDATE vsites_servico_campo SET campo='certidao_nome',tipo='text',nome='NOME',valor='',largura='470',mascara='',site='1',ordenacao='1',obrigatorio='1'
						WHERE id_servico_campo='768';
--26/05/2011 17:31:01
UPDATE vsites_servico_campo SET campo='certidao_rg',tipo='text',nome='RG',valor='',largura='470',mascara='',site='1',ordenacao='2',obrigatorio='0'
						WHERE id_servico_campo='1167';
--26/05/2011 17:31:01
UPDATE vsites_servico_campo SET campo='certidao_cpf',tipo='text',nome='CPF',valor='',largura='470',mascara='',site='1',ordenacao='3',obrigatorio='0'
						WHERE id_servico_campo='315';
--26/05/2011 17:31:01
UPDATE vsites_servico_campo SET campo='certidao_cnpj',tipo='text',nome='CNPJ',valor='',largura='470',mascara='',site='1',ordenacao='4',obrigatorio='0'
						WHERE id_servico_campo='232';
--26/05/2011 17:31:01
UPDATE vsites_servico_campo SET campo='certidao_estado',tipo='text',nome='ESTADO',valor='',largura='470',mascara='',site='1',ordenacao='5',obrigatorio='1'
						WHERE id_servico_campo='508';
--26/05/2011 17:31:01
UPDATE vsites_servico_campo SET campo='certidao_cidade',tipo='text',nome='CIDADE',valor='',largura='470',mascara='',site='1',ordenacao='6',obrigatorio='1'
						WHERE id_servico_campo='144';
--26/05/2011 17:31:01
UPDATE vsites_servico_campo SET campo='certidao_finalidade',tipo='text',nome='FINALIDADE',valor='',largura='470',mascara='',site='0',ordenacao='7',obrigatorio='0'
						WHERE id_servico_campo='1558';
--26/05/2011 17:31:01
UPDATE vsites_servico_campo SET campo='certidao_protocolo',tipo='text',nome='PROTOCOLO',valor='',largura='470',mascara='',site='0',ordenacao='8',obrigatorio='1'
						WHERE id_servico_campo='1559';
--26/05/2011 17:31:01
DELETE FROM vsites_servico_campo WHERE id_servico_campo = '' AND id_servico='7';
--26/05/2011 17:31:07
UPDATE vsites_servico SET dias='', status='Ativo', descricao='Executivos Fiscais', site='1',desc_site='Certidão de Executivos Fiscais',servico_desc='',site_menu='1' WHERE id_servico='7';
--26/05/2011 17:31:07
UPDATE vsites_servico_campo SET campo='certidao_nome',tipo='text',nome='NOME',valor='',largura='470',mascara='',site='1',ordenacao='1',obrigatorio='1'
						WHERE id_servico_campo='768';
--26/05/2011 17:31:07
UPDATE vsites_servico_campo SET campo='certidao_rg',tipo='text',nome='RG',valor='',largura='470',mascara='',site='1',ordenacao='2',obrigatorio='0'
						WHERE id_servico_campo='1167';
--26/05/2011 17:31:07
UPDATE vsites_servico_campo SET campo='certidao_cpf',tipo='text',nome='CPF',valor='',largura='470',mascara='',site='1',ordenacao='3',obrigatorio='0'
						WHERE id_servico_campo='315';
--26/05/2011 17:31:07
UPDATE vsites_servico_campo SET campo='certidao_cnpj',tipo='text',nome='CNPJ',valor='',largura='470',mascara='',site='1',ordenacao='4',obrigatorio='0'
						WHERE id_servico_campo='232';
--26/05/2011 17:31:07
UPDATE vsites_servico_campo SET campo='certidao_estado',tipo='text',nome='ESTADO',valor='',largura='470',mascara='',site='1',ordenacao='5',obrigatorio='1'
						WHERE id_servico_campo='508';
--26/05/2011 17:31:07
UPDATE vsites_servico_campo SET campo='certidao_cidade',tipo='text',nome='CIDADE',valor='',largura='470',mascara='',site='1',ordenacao='6',obrigatorio='1'
						WHERE id_servico_campo='144';
--26/05/2011 17:31:07
UPDATE vsites_servico_campo SET campo='certidao_finalidade',tipo='text',nome='FINALIDADE',valor='',largura='470',mascara='',site='0',ordenacao='7',obrigatorio='0'
						WHERE id_servico_campo='1558';
--26/05/2011 17:31:07
UPDATE vsites_servico_campo SET campo='certidao_protocolo',tipo='text',nome='PROTOCOLO',valor='',largura='470',mascara='',site='0',ordenacao='8',obrigatorio='1'
						WHERE id_servico_campo='1559';
--26/05/2011 17:31:07
DELETE FROM vsites_servico_campo WHERE id_servico_campo = '' AND id_servico='7';
--26/05/2011 17:31:46
UPDATE vsites_servico SET dias='', status='Ativo', descricao='Negativa de Protesto', site='1',desc_site='Certidão de Negativa de Protesto',servico_desc='',site_menu='1' WHERE id_servico='5';
--26/05/2011 17:31:46
UPDATE vsites_servico_campo SET campo='certidao_nome',tipo='text',nome='NOME',valor='',largura='470',mascara='',site='1',ordenacao='1',obrigatorio='1'
						WHERE id_servico_campo='787';
--26/05/2011 17:31:46
UPDATE vsites_servico_campo SET campo='certidao_rg',tipo='text',nome='RG',valor='',largura='470',mascara='',site='1',ordenacao='2',obrigatorio='0'
						WHERE id_servico_campo='1184';
--26/05/2011 17:31:46
UPDATE vsites_servico_campo SET campo='certidao_cpf',tipo='text',nome='CPF',valor='',largura='470',mascara='',site='1',ordenacao='3',obrigatorio='0'
						WHERE id_servico_campo='329';
--26/05/2011 17:31:46
UPDATE vsites_servico_campo SET campo='certidao_cnpj',tipo='text',nome='CNPJ',valor='',largura='470',mascara='',site='1',ordenacao='4',obrigatorio='0'
						WHERE id_servico_campo='243';
--26/05/2011 17:31:46
UPDATE vsites_servico_campo SET campo='certidao_estado',tipo='text',nome='ESTADO',valor='',largura='470',mascara='',site='1',ordenacao='5',obrigatorio='1'
						WHERE id_servico_campo='529';
--26/05/2011 17:31:46
UPDATE vsites_servico_campo SET campo='certidao_cidade',tipo='text',nome='CIDADE',valor='',largura='470',mascara='',site='1',ordenacao='6',obrigatorio='1'
						WHERE id_servico_campo='165';
--26/05/2011 17:31:46
UPDATE vsites_servico_campo SET campo='certidao_comarca_forum',tipo='text',nome='COMARCA',valor='',largura='470',mascara='',site='1',ordenacao='7',obrigatorio='0'
						WHERE id_servico_campo='1675';
--26/05/2011 17:31:46
UPDATE vsites_servico_campo SET campo='certidao_cartorio',tipo='text',nome='CARTORIO',valor='',largura='470',mascara='',site='1',ordenacao='8',obrigatorio='0'
						WHERE id_servico_campo='56';
--26/05/2011 17:31:46
UPDATE vsites_servico_campo SET campo='certidao_qtdd_cartorio',tipo='text',nome='NUMERO DO CARTORIO',valor='',largura='470',mascara='',site='1',ordenacao='9',obrigatorio='1'
						WHERE id_servico_campo='1596';
--26/05/2011 17:31:46
DELETE FROM vsites_servico_campo WHERE id_servico_campo = '' AND id_servico='5';
--26/05/2011 17:31:55
UPDATE vsites_servico SET dias='', status='Ativo', descricao='Certidão Quinzenária', site='1',desc_site='Certidão Quinzenária',servico_desc='<p>
São certidões de matriculas que correspondem a um período de quinze (15) anos.
</p>',site_menu='1' WHERE id_servico='158';
--26/05/2011 17:31:55
UPDATE vsites_servico_campo SET campo='certidao_cartorio',tipo='text',nome='CARTÓRIO',valor='',largura='470',mascara='',site='1',ordenacao='1',obrigatorio='1'
						WHERE id_servico_campo='1388';
--26/05/2011 17:31:55
UPDATE vsites_servico_campo SET campo='certidao_matricula',tipo='text',nome='MATRÍCULA',valor='',largura='470',mascara='',site='1',ordenacao='2',obrigatorio='1'
						WHERE id_servico_campo='1389';
--26/05/2011 17:31:55
UPDATE vsites_servico_campo SET campo='certidao_estado',tipo='text',nome='UF',valor='',largura='470',mascara='',site='1',ordenacao='3',obrigatorio='1'
						WHERE id_servico_campo='1391';
--26/05/2011 17:31:55
UPDATE vsites_servico_campo SET campo='certidao_cidade',tipo='text',nome='CIDADE',valor='',largura='470',mascara='',site='1',ordenacao='4',obrigatorio='1'
						WHERE id_servico_campo='1390';
--26/05/2011 17:31:55
DELETE FROM vsites_servico_campo WHERE id_servico_campo = '' AND id_servico='158';
--26/05/2011 17:32:03
UPDATE vsites_servico SET dias='', status='Ativo', descricao='Certidão Trintenária', site='1',desc_site='Certidão Trintenária',servico_desc='<p>
São certidões de matriculas que correspondem a um período de vinte (30) anos.
</p>',site_menu='1' WHERE id_servico='164';
--26/05/2011 17:32:03
UPDATE vsites_servico_campo SET campo='certidao_cartorio',tipo='text',nome='CARTÓRIO',valor='',largura='470',mascara='',site='1',ordenacao='1',obrigatorio='1'
						WHERE id_servico_campo='1412';
--26/05/2011 17:32:03
UPDATE vsites_servico_campo SET campo='certidao_matricula',tipo='text',nome='MATRÍCULA',valor='',largura='470',mascara='',site='1',ordenacao='2',obrigatorio='1'
						WHERE id_servico_campo='1413';
--26/05/2011 17:32:03
UPDATE vsites_servico_campo SET campo='certidao_estado',tipo='text',nome='UF',valor='',largura='470',mascara='',site='1',ordenacao='3',obrigatorio='1'
						WHERE id_servico_campo='1415';
--26/05/2011 17:32:03
UPDATE vsites_servico_campo SET campo='certidao_cidade',tipo='text',nome='CIDADE',valor='',largura='470',mascara='',site='1',ordenacao='4',obrigatorio='1'
						WHERE id_servico_campo='1414';
--26/05/2011 17:32:03
DELETE FROM vsites_servico_campo WHERE id_servico_campo = '' AND id_servico='164';
--26/05/2011 17:32:45
UPDATE vsites_servico SET dias='', status='Ativo', descricao='Inteiro Teor - Casamento', site='1',desc_site='Inteiro Teor - Casamento',servico_desc='',site_menu='1' WHERE id_servico='10';
--26/05/2011 17:32:45
UPDATE vsites_servico_campo SET campo='certidao_nome',tipo='text',nome='NOME',valor='',largura='470',mascara='',site='1',ordenacao='1',obrigatorio='1'
						WHERE id_servico_campo='772';
--26/05/2011 17:32:45
UPDATE vsites_servico_campo SET campo='certidao_esposa',tipo='text',nome='ESPOSA/ESPOSO',valor='',largura='470',mascara='',site='1',ordenacao='2',obrigatorio='1'
						WHERE id_servico_campo='465';
--26/05/2011 17:32:45
UPDATE vsites_servico_campo SET campo='certidao_data_casamento',tipo='text',nome='DATA DE CASAMENTO',valor='',largura='470',mascara='',site='1',ordenacao='3',obrigatorio='1'
						WHERE id_servico_campo='365';
--26/05/2011 17:32:45
UPDATE vsites_servico_campo SET campo='certidao_livro',tipo='text',nome='LIVRO',valor='',largura='470',mascara='',site='1',ordenacao='4',obrigatorio='0'
						WHERE id_servico_campo='624';
--26/05/2011 17:32:45
UPDATE vsites_servico_campo SET campo='certidao_folha',tipo='text',nome='FOLHA',valor='',largura='470',mascara='',site='1',ordenacao='5',obrigatorio='0'
						WHERE id_servico_campo='602';
--26/05/2011 17:32:45
UPDATE vsites_servico_campo SET campo='certidao_registro',tipo='text',nome='REGISTRO',valor='',largura='470',mascara='',site='1',ordenacao='6',obrigatorio='0'
						WHERE id_servico_campo='1047';
--26/05/2011 17:32:45
UPDATE vsites_servico_campo SET campo='certidao_estado',tipo='text',nome='ESTADO',valor='',largura='470',mascara='',site='1',ordenacao='7',obrigatorio='1'
						WHERE id_servico_campo='512';
--26/05/2011 17:32:45
UPDATE vsites_servico_campo SET campo='certidao_cidade',tipo='text',nome='CIDADE',valor='',largura='470',mascara='',site='1',ordenacao='8',obrigatorio='1'
						WHERE id_servico_campo='148';
--26/05/2011 17:32:45
UPDATE vsites_servico_campo SET campo='certidao_averbacao',tipo='text',nome='AVERBACAO',valor='',largura='470',mascara='',site='1',ordenacao='9',obrigatorio='0'
						WHERE id_servico_campo='8';
--26/05/2011 17:32:45
UPDATE vsites_servico_campo SET campo='certidao_cartorio',tipo='text',nome='CARTORIO',valor='',largura='470',mascara='',site='1',ordenacao='10',obrigatorio='0'
						WHERE id_servico_campo='47';
--26/05/2011 17:32:45
UPDATE vsites_servico_campo SET campo='certidao_finalidade',tipo='text',nome='FINALIDADE DO DOCUMENTO',valor='',largura='470',mascara='',site='1',ordenacao='11',obrigatorio='0'
						WHERE id_servico_campo='581';
--26/05/2011 17:32:45
DELETE FROM vsites_servico_campo WHERE id_servico_campo = '' AND id_servico='10';
--26/05/2011 17:33:11
UPDATE vsites_servico SET dias='', status='Ativo', descricao='Registro de Contrato - CDT', site='1',desc_site='Registro de Contrato - CDT',servico_desc='',site_menu='1' WHERE id_servico='12';
--26/05/2011 17:33:11
UPDATE vsites_servico_campo SET campo='certidao_nome',tipo='text',nome='NOME',valor='',largura='470',mascara='',site='1',ordenacao='1',obrigatorio='1'
						WHERE id_servico_campo='802';
--26/05/2011 17:33:11
UPDATE vsites_servico_campo SET campo='certidao_rg',tipo='text',nome='RG',valor='',largura='470',mascara='',site='1',ordenacao='2',obrigatorio='0'
						WHERE id_servico_campo='1194';
--26/05/2011 17:33:11
UPDATE vsites_servico_campo SET campo='certidao_cpf',tipo='text',nome='CPF',valor='',largura='470',mascara='',site='1',ordenacao='3',obrigatorio='0'
						WHERE id_servico_campo='340';
--26/05/2011 17:33:11
UPDATE vsites_servico_campo SET campo='certidao_cnpj',tipo='text',nome='CNPJ',valor='',largura='470',mascara='',site='1',ordenacao='4',obrigatorio='0'
						WHERE id_servico_campo='253';
--26/05/2011 17:33:11
UPDATE vsites_servico_campo SET campo='certidao_estado',tipo='text',nome='ESTADO',valor='',largura='470',mascara='',site='1',ordenacao='5',obrigatorio='1'
						WHERE id_servico_campo='545';
--26/05/2011 17:33:11
UPDATE vsites_servico_campo SET campo='certidao_cidade',tipo='text',nome='CIDADE',valor='',largura='470',mascara='',site='1',ordenacao='6',obrigatorio='1'
						WHERE id_servico_campo='181';
--26/05/2011 17:33:11
UPDATE vsites_servico_campo SET campo='certidao_cartorio',tipo='text',nome='CARTORIO',valor='',largura='470',mascara='',site='1',ordenacao='7',obrigatorio='1'
						WHERE id_servico_campo='65';
--26/05/2011 17:33:11
UPDATE vsites_servico_campo SET campo='certidao_n_contrato',tipo='text',nome='NUMERO DO CONTRATO',valor='',largura='470',mascara='',site='1',ordenacao='8',obrigatorio='0'
						WHERE id_servico_campo='851';
--26/05/2011 17:33:11
UPDATE vsites_servico_campo SET campo='certidao_valor',tipo='text',nome='VALOR',valor='',largura='470',mascara='',site='1',ordenacao='9',obrigatorio='0'
						WHERE id_servico_campo='1238';
--26/05/2011 17:33:11
UPDATE vsites_servico_campo SET campo='certidao_protocolo',tipo='text',nome='PROTOCOLO',valor='',largura='470',mascara='',site='0',ordenacao='10',obrigatorio='0'
						WHERE id_servico_campo='1018';
--26/05/2011 17:33:11
DELETE FROM vsites_servico_campo WHERE id_servico_campo = '' AND id_servico='12';
--26/05/2011 17:33:27
UPDATE vsites_servico SET dias='', status='Ativo', descricao='Distribuições Criminais', site='1',desc_site='Distribuições Criminais',servico_desc='',site_menu='1' WHERE id_servico='13';
--26/05/2011 17:33:27
UPDATE vsites_servico_campo SET campo='certidao_nome',tipo='text',nome='NOME',valor='',largura='470',mascara='',site='1',ordenacao='1',obrigatorio='1'
						WHERE id_servico_campo='764';
--26/05/2011 17:33:27
UPDATE vsites_servico_campo SET campo='certidao_data_nascimento',tipo='text',nome='DATA DE NASCIMENTO',valor='',largura='470',mascara='',site='1',ordenacao='2',obrigatorio='1'
						WHERE id_servico_campo='395';
--26/05/2011 17:33:27
UPDATE vsites_servico_campo SET campo='certidao_rg',tipo='text',nome='RG',valor='',largura='470',mascara='',site='1',ordenacao='3',obrigatorio='0'
						WHERE id_servico_campo='1162';
--26/05/2011 17:33:27
UPDATE vsites_servico_campo SET campo='certidao_orgao_emissor',tipo='text',nome='ORGAO EMISSOR',valor='',largura='470',mascara='',site='1',ordenacao='4',obrigatorio='0'
						WHERE id_servico_campo='891';
--26/05/2011 17:33:27
UPDATE vsites_servico_campo SET campo='certidao_cpf',tipo='text',nome='CPF',valor='',largura='470',mascara='',site='1',ordenacao='5',obrigatorio='0'
						WHERE id_servico_campo='310';
--26/05/2011 17:33:27
UPDATE vsites_servico_campo SET campo='certidao_cnpj',tipo='text',nome='CNPJ',valor='',largura='470',mascara='',site='1',ordenacao='6',obrigatorio='0'
						WHERE id_servico_campo='228';
--26/05/2011 17:33:27
UPDATE vsites_servico_campo SET campo='certidao_nacionalidade',tipo='text',nome='NATURALIDADE',valor='',largura='470',mascara='',site='1',ordenacao='7',obrigatorio='0'
						WHERE id_servico_campo='720';
--26/05/2011 17:33:27
UPDATE vsites_servico_campo SET campo='certidao_estado',tipo='text',nome='ESTADO',valor='',largura='470',mascara='',site='1',ordenacao='8',obrigatorio='1'
						WHERE id_servico_campo='503';
--26/05/2011 17:33:27
UPDATE vsites_servico_campo SET campo='certidao_cidade',tipo='text',nome='CIDADE',valor='',largura='470',mascara='',site='1',ordenacao='9',obrigatorio='1'
						WHERE id_servico_campo='139';
--26/05/2011 17:33:27
UPDATE vsites_servico_campo SET campo='certidao_mae',tipo='text',nome='MAE',valor='',largura='470',mascara='',site='1',ordenacao='10',obrigatorio='1'
						WHERE id_servico_campo='647';
--26/05/2011 17:33:27
UPDATE vsites_servico_campo SET campo='certidao_pai',tipo='text',nome='PAI',valor='',largura='470',mascara='',site='1',ordenacao='11',obrigatorio='0'
						WHERE id_servico_campo='913';
--26/05/2011 17:33:27
UPDATE vsites_servico_campo SET campo='certidao_protocolo',tipo='text',nome='PROTOCOLO',valor='',largura='470',mascara='',site='0',ordenacao='12',obrigatorio='0'
						WHERE id_servico_campo='983';
--26/05/2011 17:33:27
DELETE FROM vsites_servico_campo WHERE id_servico_campo = '' AND id_servico='13';
--26/05/2011 17:33:36
UPDATE vsites_servico SET dias='', status='Ativo', descricao='Justiça do Trabalho', site='1',desc_site='Justiça do Trabalho',servico_desc='',site_menu='' WHERE id_servico='9';
--26/05/2011 17:33:36
UPDATE vsites_servico_campo SET campo='certidao_nome',tipo='text',nome='NOME',valor='',largura='470',mascara='',site='1',ordenacao='1',obrigatorio='1'
						WHERE id_servico_campo='776';
--26/05/2011 17:33:36
UPDATE vsites_servico_campo SET campo='certidao_finalidade',tipo='text',nome='FINALIDADE',valor='',largura='470',mascara='',site='1',ordenacao='2',obrigatorio='0'
						WHERE id_servico_campo='1556';
--26/05/2011 17:33:36
UPDATE vsites_servico_campo SET campo='certidao_cpf',tipo='text',nome='CPF',valor='',largura='470',mascara='',site='1',ordenacao='3',obrigatorio='0'
						WHERE id_servico_campo='321';
--26/05/2011 17:33:36
UPDATE vsites_servico_campo SET campo='certidao_cnpj',tipo='text',nome='CNPJ',valor='',largura='470',mascara='',site='1',ordenacao='4',obrigatorio='0'
						WHERE id_servico_campo='236';
--26/05/2011 17:33:36
UPDATE vsites_servico_campo SET campo='certidao_estado',tipo='text',nome='ESTADO',valor='',largura='470',mascara='',site='1',ordenacao='5',obrigatorio='1'
						WHERE id_servico_campo='516';
--26/05/2011 17:33:36
UPDATE vsites_servico_campo SET campo='certidao_cidade',tipo='text',nome='CIDADE',valor='',largura='470',mascara='',site='1',ordenacao='6',obrigatorio='1'
						WHERE id_servico_campo='152';
--26/05/2011 17:33:36
UPDATE vsites_servico_campo SET campo='certidao_rg',tipo='text',nome='RG',valor='',largura='470',mascara='',site='1',ordenacao='7',obrigatorio='0'
						WHERE id_servico_campo='1173';
--26/05/2011 17:33:36
DELETE FROM vsites_servico_campo WHERE id_servico_campo = '' AND id_servico='9';
--26/05/2011 17:34:33
UPDATE vsites_servico SET dias='', status='Ativo', descricao='Execução Criminal', site='1',desc_site='Execução Criminal',servico_desc='',site_menu='1' WHERE id_servico='14';
--26/05/2011 17:34:33
UPDATE vsites_servico_campo SET campo='certidao_nome',tipo='text',nome='NOME',valor='',largura='470',mascara='',site='1',ordenacao='1',obrigatorio='1'
						WHERE id_servico_campo='767';
--26/05/2011 17:34:33
UPDATE vsites_servico_campo SET campo='certidao_data_nascimento',tipo='text',nome='DATA DE NASCIMENTO',valor='',largura='470',mascara='',site='1',ordenacao='2',obrigatorio='1'
						WHERE id_servico_campo='396';
--26/05/2011 17:34:33
UPDATE vsites_servico_campo SET campo='certidao_rg',tipo='text',nome='RG',valor='',largura='470',mascara='',site='1',ordenacao='3',obrigatorio='1'
						WHERE id_servico_campo='1166';
--26/05/2011 17:34:33
UPDATE vsites_servico_campo SET campo='certidao_orgao_emissor',tipo='text',nome='ORGAO EMISSOR',valor='',largura='470',mascara='',site='1',ordenacao='4',obrigatorio='1'
						WHERE id_servico_campo='892';
--26/05/2011 17:34:33
UPDATE vsites_servico_campo SET campo='certidao_cpf',tipo='text',nome='CPF',valor='',largura='470',mascara='',site='1',ordenacao='5',obrigatorio='1'
						WHERE id_servico_campo='314';
--26/05/2011 17:34:33
UPDATE vsites_servico_campo SET campo='certidao_nacionalidade',tipo='text',nome='NATURALIDADE',valor='',largura='470',mascara='',site='1',ordenacao='6',obrigatorio='1'
						WHERE id_servico_campo='721';
--26/05/2011 17:34:33
UPDATE vsites_servico_campo SET campo='certidao_estado',tipo='text',nome='ESTADO',valor='',largura='470',mascara='',site='1',ordenacao='7',obrigatorio='1'
						WHERE id_servico_campo='507';
--26/05/2011 17:34:33
UPDATE vsites_servico_campo SET campo='certidao_cidade',tipo='text',nome='CIDADE',valor='',largura='470',mascara='',site='1',ordenacao='8',obrigatorio='1'
						WHERE id_servico_campo='143';
--26/05/2011 17:34:33
UPDATE vsites_servico_campo SET campo='certidao_mae',tipo='text',nome='MAE',valor='',largura='470',mascara='',site='1',ordenacao='9',obrigatorio='1'
						WHERE id_servico_campo='648';
--26/05/2011 17:34:33
UPDATE vsites_servico_campo SET campo='certidao_pai',tipo='text',nome='PAI',valor='',largura='470',mascara='',site='1',ordenacao='10',obrigatorio='0'
						WHERE id_servico_campo='914';
--26/05/2011 17:34:33
UPDATE vsites_servico_campo SET campo='certidao_protocolo',tipo='text',nome='PROTOCOLO',valor='',largura='470',mascara='',site='0',ordenacao='11',obrigatorio='0'
						WHERE id_servico_campo='987';
--26/05/2011 17:34:33
DELETE FROM vsites_servico_campo WHERE id_servico_campo = '' AND id_servico='14';
--26/05/2011 17:34:54
UPDATE vsites_servico SET dias='', status='Ativo', descricao='Pesquisa Detran', site='1',desc_site='Pesquisa Detran',servico_desc='',site_menu='1' WHERE id_servico='16';
--26/05/2011 17:34:54
UPDATE vsites_servico_campo SET campo='certidao_nome',tipo='text',nome='NOME',valor='',largura='470',mascara='',site='1',ordenacao='1',obrigatorio='1'
						WHERE id_servico_campo='794';
--26/05/2011 17:34:54
UPDATE vsites_servico_campo SET campo='certidao_rg',tipo='text',nome='RG',valor='',largura='470',mascara='',site='1',ordenacao='2',obrigatorio='0'
						WHERE id_servico_campo='1189';
--26/05/2011 17:34:54
UPDATE vsites_servico_campo SET campo='certidao_cpf',tipo='text',nome='CPF',valor='',largura='470',mascara='',site='1',ordenacao='3',obrigatorio='0'
						WHERE id_servico_campo='333';
--26/05/2011 17:34:54
UPDATE vsites_servico_campo SET campo='certidao_cnpj',tipo='text',nome='CNPJ',valor='',largura='470',mascara='',site='1',ordenacao='4',obrigatorio='0'
						WHERE id_servico_campo='247';
--26/05/2011 17:34:54
UPDATE vsites_servico_campo SET campo='certidao_estado',tipo='text',nome='ESTADO',valor='',largura='470',mascara='',site='1',ordenacao='5',obrigatorio='1'
						WHERE id_servico_campo='538';
--26/05/2011 17:34:54
UPDATE vsites_servico_campo SET campo='certidao_cidade',tipo='text',nome='CIDADE',valor='',largura='470',mascara='',site='1',ordenacao='6',obrigatorio='1'
						WHERE id_servico_campo='174';
--26/05/2011 17:34:54
UPDATE vsites_servico_campo SET campo='certidao_protocolo',tipo='text',nome='PROTOCOLO',valor='',largura='470',mascara='',site='0',ordenacao='7',obrigatorio='0'
						WHERE id_servico_campo='1012';
--26/05/2011 17:34:54
UPDATE vsites_servico_campo SET campo='certidao_devedor',tipo='text',nome='DEVEDOR',valor='',largura='470',mascara='',site='0',ordenacao='8',obrigatorio='0'
						WHERE id_servico_campo='1594';
--26/05/2011 17:34:54
UPDATE vsites_servico_campo SET campo='certidao_devedor_cpf',tipo='text',nome='CPF DEVEDOR',valor='',largura='470',mascara='',site='0',ordenacao='9',obrigatorio='0'
						WHERE id_servico_campo='1595';
--26/05/2011 17:34:54
DELETE FROM vsites_servico_campo WHERE id_servico_campo = '' AND id_servico='16';
--26/05/2011 17:35:06
UPDATE vsites_servico SET dias='', status='Ativo', descricao='Notificação Eletrônica', site='',desc_site='',servico_desc='',site_menu='' WHERE id_servico='17';
--26/05/2011 17:35:06
UPDATE vsites_servico_campo SET campo='certidao_requerente',tipo='text',nome='CLIENTE',valor='',largura='470',mascara='',site='1',ordenacao='1',obrigatorio='0'
						WHERE id_servico_campo='1257';
--26/05/2011 17:35:06
UPDATE vsites_servico_campo SET campo='certidao_nome',tipo='text',nome='NOME DO NOTIFICADO',valor='',largura='470',mascara='',site='1',ordenacao='2',obrigatorio='0'
						WHERE id_servico_campo='789';
--26/05/2011 17:35:06
UPDATE vsites_servico_campo SET campo='certidao_cpf',tipo='text',nome='CPF DO NOTIFICADO',valor='',largura='470',mascara='',site='1',ordenacao='3',obrigatorio='0'
						WHERE id_servico_campo='330';
--26/05/2011 17:35:06
UPDATE vsites_servico_campo SET campo='certidao_rg',tipo='text',nome='RG DO NOTIFICADO',valor='',largura='470',mascara='',site='1',ordenacao='4',obrigatorio='0'
						WHERE id_servico_campo='1185';
--26/05/2011 17:35:06
UPDATE vsites_servico_campo SET campo='certidao_cnpj',tipo='text',nome='CNPJ DO NOTIFICADO',valor='',largura='470',mascara='',site='1',ordenacao='5',obrigatorio='0'
						WHERE id_servico_campo='244';
--26/05/2011 17:35:06
UPDATE vsites_servico_campo SET campo='certidao_endereco',tipo='text',nome='ENDEREÇO DO NOTIFICADO',valor='',largura='470',mascara='',site='1',ordenacao='6',obrigatorio='0'
						WHERE id_servico_campo='1258';
--26/05/2011 17:35:06
UPDATE vsites_servico_campo SET campo='certidao_estado',tipo='text',nome='ESTADO DO NOTIFICADO',valor='',largura='470',mascara='',site='1',ordenacao='7',obrigatorio='0'
						WHERE id_servico_campo='531';
--26/05/2011 17:35:06
UPDATE vsites_servico_campo SET campo='certidao_cidade',tipo='text',nome='CIDADE DO NOTIFICADO',valor='',largura='470',mascara='',site='1',ordenacao='8',obrigatorio='0'
						WHERE id_servico_campo='167';
--26/05/2011 17:35:06
UPDATE vsites_servico_campo SET campo='certidao_campo_cep',tipo='text',nome='CEP DO NOTIFICADO',valor='',largura='470',mascara='',site='1',ordenacao='9',obrigatorio='0'
						WHERE id_servico_campo='1259';
--26/05/2011 17:35:06
UPDATE vsites_servico_campo SET campo='certidao_cartorio',tipo='text',nome='CARTORIO',valor='',largura='470',mascara='',site='1',ordenacao='10',obrigatorio='0'
						WHERE id_servico_campo='57';
--26/05/2011 17:35:06
UPDATE vsites_servico_campo SET campo='certidao_valor',tipo='text',nome='VALOR',valor='',largura='470',mascara='',site='1',ordenacao='11',obrigatorio='0'
						WHERE id_servico_campo='1260';
--26/05/2011 17:35:06
UPDATE vsites_servico_campo SET campo='certidao_cod_agencia',tipo='text',nome='CODIGO DA AGÊNCIA',valor='',largura='470',mascara='',site='1',ordenacao='12',obrigatorio='0'
						WHERE id_servico_campo='1261';
--26/05/2011 17:35:06
UPDATE vsites_servico_campo SET campo='certidao_conta',tipo='text',nome='NÚMERO DA CONTA',valor='',largura='470',mascara='',site='1',ordenacao='13',obrigatorio='0'
						WHERE id_servico_campo='1262';
--26/05/2011 17:35:06
UPDATE vsites_servico_campo SET campo='certidao_modelo',tipo='text',nome='MODELO',valor='',largura='470',mascara='',site='0',ordenacao='14',obrigatorio='0'
						WHERE id_servico_campo='1263';
--26/05/2011 17:35:06
UPDATE vsites_servico_campo SET campo='certidao_numero_not',tipo='text',nome='NÚMERO DO DOCUMENTO',valor='',largura='470',mascara='',site='1',ordenacao='15',obrigatorio='0'
						WHERE id_servico_campo='1264';
--26/05/2011 17:35:06
UPDATE vsites_servico_campo SET campo='certidao_nosso_numero',tipo='text',nome='NOSSO NÚMERO',valor='',largura='470',mascara='',site='1',ordenacao='16',obrigatorio='0'
						WHERE id_servico_campo='1265';
--26/05/2011 17:35:06
UPDATE vsites_servico_campo SET campo='certidao_duplicata',tipo='text',nome='DUPLICATA',valor='',largura='470',mascara='',site='1',ordenacao='17',obrigatorio='0'
						WHERE id_servico_campo='1266';
--26/05/2011 17:35:06
UPDATE vsites_servico_campo SET campo='certidao_emissao',tipo='text',nome='EMISSÃO',valor='',largura='470',mascara='',site='1',ordenacao='18',obrigatorio='0'
						WHERE id_servico_campo='1267';
--26/05/2011 17:35:06
UPDATE vsites_servico_campo SET campo='certidao_agencia',tipo='text',nome='AGÊNCIA',valor='',largura='470',mascara='',site='1',ordenacao='19',obrigatorio='0'
						WHERE id_servico_campo='1268';
--26/05/2011 17:35:06
UPDATE vsites_servico_campo SET campo='certidao_banco',tipo='text',nome='BANCO COBRADOR',valor='',largura='470',mascara='',site='1',ordenacao='20',obrigatorio='0'
						WHERE id_servico_campo='1269';
--26/05/2011 17:35:06
UPDATE vsites_servico_campo SET campo='certidao_vencimento',tipo='text',nome='VENCIMENTO',valor='',largura='470',mascara='',site='1',ordenacao='21',obrigatorio='0'
						WHERE id_servico_campo='1270';
--26/05/2011 17:35:06
UPDATE vsites_servico_campo SET campo='certidao_cart_titulo',tipo='text',nome='CARTEIRA DO TÍTULO',valor='',largura='470',mascara='',site='1',ordenacao='22',obrigatorio='0'
						WHERE id_servico_campo='1271';
--26/05/2011 17:35:06
UPDATE vsites_servico_campo SET campo='certidao_emissao_dir_cred',tipo='text',nome='EMISSÃO DO DIREITO CRED',valor='',largura='470',mascara='',site='0',ordenacao='23',obrigatorio='0'
						WHERE id_servico_campo='1273';
--26/05/2011 17:35:06
UPDATE vsites_servico_campo SET campo='certidao_num_dir_cred',tipo='text',nome='NÚMERO DIREITO CRED',valor='',largura='470',mascara='',site='0',ordenacao='24',obrigatorio='0'
						WHERE id_servico_campo='1274';
--26/05/2011 17:35:06
UPDATE vsites_servico_campo SET campo='certidao_num_contrato_dir_cred',tipo='text',nome='CONTRATO DO DIREITO CRED',valor='',largura='470',mascara='',site='0',ordenacao='25',obrigatorio='0'
						WHERE id_servico_campo='1275';
--26/05/2011 17:35:06
UPDATE vsites_servico_campo SET campo='certidao_emissao_contrato',tipo='text',nome='EMISSÃO DO CONTRATO',valor='',largura='470',mascara='',site='0',ordenacao='26',obrigatorio='0'
						WHERE id_servico_campo='1276';
--26/05/2011 17:35:06
UPDATE vsites_servico_campo SET campo='certidao_modalidade',tipo='text',nome='MODALIDADE',valor='',largura='470',mascara='',site='0',ordenacao='27',obrigatorio='0'
						WHERE id_servico_campo='1277';
--26/05/2011 17:35:06
UPDATE vsites_servico_campo SET campo='certidao_objeto_contrato_cred',tipo='text',nome='OBJETO DO CONTRATO DIR CRED',valor='',largura='470',mascara='',site='0',ordenacao='28',obrigatorio='0'
						WHERE id_servico_campo='1278';
--26/05/2011 17:35:06
UPDATE vsites_servico_campo SET campo='certidao_cpf_contratado',tipo='text',nome='CPF CONTRATADO',valor='',largura='470',mascara='',site='0',ordenacao='29',obrigatorio='0'
						WHERE id_servico_campo='1279';
--26/05/2011 17:35:06
UPDATE vsites_servico_campo SET campo='certidao_data_protocolo',tipo='text',nome='Data do Protocolo',valor='',largura='470',mascara='',site='0',ordenacao='30',obrigatorio='0'
						WHERE id_servico_campo='1280';
--26/05/2011 17:35:06
UPDATE vsites_servico_campo SET campo='certidao_protocolo',tipo='text',nome='PROTOCOLO',valor='',largura='470',mascara='',site='0',ordenacao='31',obrigatorio='0'
						WHERE id_servico_campo='1005';
--26/05/2011 17:35:06
UPDATE vsites_servico_campo SET campo='certidao_ocorrencia',tipo='text',nome='Ocorrencia',valor='',largura='470',mascara='',site='0',ordenacao='32',obrigatorio='0'
						WHERE id_servico_campo='1282';
--26/05/2011 17:35:06
UPDATE vsites_servico_campo SET campo='certidao_data_ocorrencia',tipo='text',nome='Data da Ocorrencia',valor='',largura='470',mascara='',site='0',ordenacao='33',obrigatorio='0'
						WHERE id_servico_campo='1283';
--26/05/2011 17:35:06
UPDATE vsites_servico_campo SET campo='certidao_registro',tipo='text',nome='Registro',valor='',largura='470',mascara='',site='0',ordenacao='34',obrigatorio='0'
						WHERE id_servico_campo='1284';
--26/05/2011 17:35:06
UPDATE vsites_servico_campo SET campo='certidao_data_registro',tipo='text',nome='Data do Registro',valor='',largura='470',mascara='',site='0',ordenacao='35',obrigatorio='0'
						WHERE id_servico_campo='1285';
--26/05/2011 17:35:06
UPDATE vsites_servico_campo SET campo='certidao_numero_ar',tipo='text',nome='Numero da Ar',valor='',largura='470',mascara='',site='0',ordenacao='36',obrigatorio='0'
						WHERE id_servico_campo='1281';
--26/05/2011 17:35:06
UPDATE vsites_servico_campo SET campo='conce_endereco',tipo='text',nome='CONCESSIONARIA ENDERECO',valor='',largura='470',mascara='',site='0',ordenacao='37',obrigatorio='0'
						WHERE id_servico_campo='1370';
--26/05/2011 17:35:06
UPDATE vsites_servico_campo SET campo='conce_bairro',tipo='text',nome='CONCESSIONARIA BAIRRO',valor='',largura='470',mascara='',site='0',ordenacao='38',obrigatorio='0'
						WHERE id_servico_campo='1371';
--26/05/2011 17:35:06
UPDATE vsites_servico_campo SET campo='conce_cidade',tipo='text',nome='CONCESSIONARIA CIDADE',valor='',largura='470',mascara='',site='0',ordenacao='39',obrigatorio='0'
						WHERE id_servico_campo='1372';
--26/05/2011 17:35:06
UPDATE vsites_servico_campo SET campo='conce_cep',tipo='text',nome='CONCESSIONARIA CEP',valor='',largura='470',mascara='',site='0',ordenacao='40',obrigatorio='0'
						WHERE id_servico_campo='1373';
--26/05/2011 17:35:06
UPDATE vsites_servico_campo SET campo='conce_estado',tipo='text',nome='CONCESSIONARIA ESTADO',valor='',largura='470',mascara='',site='0',ordenacao='41',obrigatorio='0'
						WHERE id_servico_campo='1374';
--26/05/2011 17:35:06
UPDATE vsites_servico_campo SET campo='conce_tel',tipo='text',nome='CONCESSIONARIA TEL',valor='',largura='470',mascara='',site='0',ordenacao='42',obrigatorio='0'
						WHERE id_servico_campo='1375';
--26/05/2011 17:35:06
UPDATE vsites_servico_campo SET campo='conce_nome',tipo='text',nome='CONCESSIONARIA',valor='',largura='470',mascara='',site='0',ordenacao='43',obrigatorio='0'
						WHERE id_servico_campo='1369';
--26/05/2011 17:35:06
UPDATE vsites_servico_campo SET campo='n_parcelas',tipo='text',nome='N PARCELAS',valor='',largura='470',mascara='',site='0',ordenacao='44',obrigatorio='0'
						WHERE id_servico_campo='1368';
--26/05/2011 17:35:06
UPDATE vsites_servico_campo SET campo='c_tel',tipo='text',nome='TEL DO CLIENTE',valor='',largura='470',mascara='',site='0',ordenacao='45',obrigatorio='0'
						WHERE id_servico_campo='1367';
--26/05/2011 17:35:06
UPDATE vsites_servico_campo SET campo='c_estado',tipo='text',nome='ESTADO DO CLIENTE',valor='',largura='470',mascara='',site='0',ordenacao='46',obrigatorio='0'
						WHERE id_servico_campo='1366';
--26/05/2011 17:35:06
UPDATE vsites_servico_campo SET campo='c_cep',tipo='text',nome='CEP DO CLIENTE',valor='',largura='470',mascara='',site='0',ordenacao='47',obrigatorio='0'
						WHERE id_servico_campo='1365';
--26/05/2011 17:35:06
UPDATE vsites_servico_campo SET campo='c_cidade',tipo='text',nome='CIDADE DO CLIENTE',valor='',largura='470',mascara='',site='0',ordenacao='48',obrigatorio='0'
						WHERE id_servico_campo='1364';
--26/05/2011 17:35:06
UPDATE vsites_servico_campo SET campo='c_bairro',tipo='text',nome='BBAIRRO DO CLIENTE',valor='',largura='470',mascara='',site='0',ordenacao='49',obrigatorio='0'
						WHERE id_servico_campo='1363';
--26/05/2011 17:35:06
UPDATE vsites_servico_campo SET campo='c_endereco',tipo='text',nome='ENDERECO DO CLIENTE',valor='',largura='470',mascara='',site='0',ordenacao='50',obrigatorio='0'
						WHERE id_servico_campo='1362';
--26/05/2011 17:35:06
UPDATE vsites_servico_campo SET campo='certidao_n_contrato',tipo='text',nome='NUMERO DO CONTRATO',valor='',largura='470',mascara='',site='1',ordenacao='51',obrigatorio='0'
						WHERE id_servico_campo='850';
--26/05/2011 17:35:06
DELETE FROM vsites_servico_campo WHERE id_servico_campo = '' AND id_servico='17';
--26/05/2011 17:35:47
UPDATE vsites_servico SET dias='', status='Ativo', descricao='Declaração de Homonímia', site='1',desc_site='Declaração de Homonímia',servico_desc='',site_menu='1' WHERE id_servico='22';
--26/05/2011 17:35:47
UPDATE vsites_servico_campo SET campo='certidao_nome',tipo='text',nome='NOME',valor='',largura='470',mascara='',site='1',ordenacao='1',obrigatorio='1'
						WHERE id_servico_campo='760';
--26/05/2011 17:35:47
UPDATE vsites_servico_campo SET campo='certidao_data_nascimento',tipo='text',nome='DATA DE NASCIMENTO',valor='',largura='470',mascara='',site='1',ordenacao='2',obrigatorio='1'
						WHERE id_servico_campo='392';
--26/05/2011 17:35:47
UPDATE vsites_servico_campo SET campo='certidao_rg',tipo='text',nome='RG',valor='',largura='470',mascara='',site='1',ordenacao='3',obrigatorio='0'
						WHERE id_servico_campo='1159';
--26/05/2011 17:35:47
UPDATE vsites_servico_campo SET campo='certidao_orgao_emissor',tipo='text',nome='ORGAO EMISSOR',valor='',largura='470',mascara='',site='1',ordenacao='4',obrigatorio='0'
						WHERE id_servico_campo='889';
--26/05/2011 17:35:47
UPDATE vsites_servico_campo SET campo='certidao_cpf',tipo='text',nome='CPF',valor='',largura='470',mascara='',site='1',ordenacao='5',obrigatorio='0'
						WHERE id_servico_campo='1499';
--26/05/2011 17:35:47
UPDATE vsites_servico_campo SET campo='certidao_cnpj',tipo='text',nome='CNPJ',valor='',largura='470',mascara='',site='1',ordenacao='6',obrigatorio='0'
						WHERE id_servico_campo='1543';
--26/05/2011 17:35:47
UPDATE vsites_servico_campo SET campo='certidao_nacionalidade',tipo='text',nome='NATURALIDADE',valor='',largura='470',mascara='',site='1',ordenacao='7',obrigatorio='0'
						WHERE id_servico_campo='719';
--26/05/2011 17:35:47
UPDATE vsites_servico_campo SET campo='certidao_estado',tipo='text',nome='ESTADO',valor='',largura='470',mascara='',site='1',ordenacao='8',obrigatorio='1'
						WHERE id_servico_campo='1501';
--26/05/2011 17:35:47
UPDATE vsites_servico_campo SET campo='certidao_cidade',tipo='text',nome='CIDADE',valor='',largura='470',mascara='',site='1',ordenacao='9',obrigatorio='1'
						WHERE id_servico_campo='1500';
--26/05/2011 17:35:47
UPDATE vsites_servico_campo SET campo='certidao_profissao',tipo='text',nome='PROFISSÃO',valor='',largura='470',mascara='',site='1',ordenacao='10',obrigatorio='1'
						WHERE id_servico_campo='929';
--26/05/2011 17:35:47
UPDATE vsites_servico_campo SET campo='certidao_mae',tipo='text',nome='MAE',valor='',largura='470',mascara='',site='1',ordenacao='11',obrigatorio='1'
						WHERE id_servico_campo='645';
--26/05/2011 17:35:47
UPDATE vsites_servico_campo SET campo='certidao_pai',tipo='text',nome='PAI',valor='',largura='470',mascara='',site='1',ordenacao='12',obrigatorio='0'
						WHERE id_servico_campo='911';
--26/05/2011 17:35:47
UPDATE vsites_servico_campo SET campo='certidao_protocolo',tipo='text',nome='PROTOCOLO',valor='',largura='470',mascara='',site='0',ordenacao='13',obrigatorio='0'
						WHERE id_servico_campo='981';
--26/05/2011 17:35:47
DELETE FROM vsites_servico_campo WHERE id_servico_campo = '' AND id_servico='22';
--26/05/2011 17:36:35
UPDATE vsites_servico SET dias='', status='Ativo', descricao='Falência e Concordata', site='1',desc_site='Falência e Concordata',servico_desc='',site_menu='1' WHERE id_servico='25';
--26/05/2011 17:36:35
UPDATE vsites_servico_campo SET campo='certidao_nome',tipo='text',nome='NOME',valor='',largura='470',mascara='',site='1',ordenacao='1',obrigatorio='1'
						WHERE id_servico_campo='769';
--26/05/2011 17:36:35
UPDATE vsites_servico_campo SET campo='certidao_rg',tipo='text',nome='RG',valor='',largura='470',mascara='',site='1',ordenacao='2',obrigatorio='0'
						WHERE id_servico_campo='1168';
--26/05/2011 17:36:35
UPDATE vsites_servico_campo SET campo='certidao_cpf',tipo='text',nome='CPF',valor='',largura='470',mascara='',site='1',ordenacao='3',obrigatorio='0'
						WHERE id_servico_campo='316';
--26/05/2011 17:36:35
UPDATE vsites_servico_campo SET campo='certidao_cnpj',tipo='text',nome='CNPJ',valor='',largura='470',mascara='',site='1',ordenacao='4',obrigatorio='0'
						WHERE id_servico_campo='233';
--26/05/2011 17:36:35
UPDATE vsites_servico_campo SET campo='certidao_estado',tipo='text',nome='ESTADO',valor='',largura='470',mascara='',site='1',ordenacao='5',obrigatorio='1'
						WHERE id_servico_campo='510';
--26/05/2011 17:36:35
UPDATE vsites_servico_campo SET campo='certidao_cidade',tipo='text',nome='CIDADE',valor='',largura='470',mascara='',site='1',ordenacao='6',obrigatorio='1'
						WHERE id_servico_campo='146';
--26/05/2011 17:36:35
UPDATE vsites_servico_campo SET campo='certidao_finalidade',tipo='text',nome='FINALIDADE',valor='',largura='470',mascara='',site='0',ordenacao='7',obrigatorio='0'
						WHERE id_servico_campo='1557';
--26/05/2011 17:36:35
UPDATE vsites_servico_campo SET campo='certidao_protocolo',tipo='text',nome='PROTOCOLO',valor='',largura='470',mascara='',site='0',ordenacao='8',obrigatorio='1'
						WHERE id_servico_campo='989';
--26/05/2011 17:36:35
DELETE FROM vsites_servico_campo WHERE id_servico_campo = '' AND id_servico='25';
--26/05/2011 17:37:06
UPDATE vsites_servico SET dias='', status='Ativo', descricao='Averbação - Divórcio', site='1',desc_site='Averbação de Divórcio',servico_desc='',site_menu='1' WHERE id_servico='29';
--26/05/2011 17:37:06
UPDATE vsites_servico_campo SET campo='certidao_nome',tipo='text',nome='NOME',valor='',largura='470',mascara='',site='1',ordenacao='1',obrigatorio='1'
						WHERE id_servico_campo='730';
--26/05/2011 17:37:06
UPDATE vsites_servico_campo SET campo='certidao_conjuge',tipo='text',nome='CONJUGE',valor='',largura='470',mascara='',site='1',ordenacao='2',obrigatorio='1'
						WHERE id_servico_campo='273';
--26/05/2011 17:37:06
UPDATE vsites_servico_campo SET campo='certidao_data_casamento',tipo='text',nome='DATA DE CASAMENTO',valor='',largura='470',mascara='',site='1',ordenacao='3',obrigatorio='1'
						WHERE id_servico_campo='362';
--26/05/2011 17:37:06
UPDATE vsites_servico_campo SET campo='certidao_livro',tipo='text',nome='LIVRO',valor='',largura='470',mascara='',site='1',ordenacao='4',obrigatorio='0'
						WHERE id_servico_campo='617';
--26/05/2011 17:37:06
UPDATE vsites_servico_campo SET campo='certidao_folha',tipo='text',nome='FOLHA',valor='',largura='470',mascara='',site='1',ordenacao='5',obrigatorio='0'
						WHERE id_servico_campo='594';
--26/05/2011 17:37:06
UPDATE vsites_servico_campo SET campo='certidao_registro',tipo='text',nome='REGISTRO',valor='',largura='470',mascara='',site='1',ordenacao='6',obrigatorio='0'
						WHERE id_servico_campo='1042';
--26/05/2011 17:37:06
UPDATE vsites_servico_campo SET campo='certidao_estado',tipo='text',nome='ESTADO',valor='',largura='470',mascara='',site='1',ordenacao='7',obrigatorio='1'
						WHERE id_servico_campo='473';
--26/05/2011 17:37:06
UPDATE vsites_servico_campo SET campo='certidao_cidade',tipo='text',nome='CIDADE',valor='',largura='470',mascara='',site='1',ordenacao='8',obrigatorio='1'
						WHERE id_servico_campo='107';
--26/05/2011 17:37:06
UPDATE vsites_servico_campo SET campo='certidao_cartorio',tipo='text',nome='CARTORIO',valor='',largura='470',mascara='',site='1',ordenacao='9',obrigatorio='0'
						WHERE id_servico_campo='26';
--26/05/2011 17:37:06
UPDATE vsites_servico_campo SET campo='certidao_averbacao',tipo='text',nome='AVERBACAO',valor='',largura='470',mascara='',site='1',ordenacao='10',obrigatorio='0'
						WHERE id_servico_campo='3';
--26/05/2011 17:37:06
UPDATE vsites_servico_campo SET campo='certidao_finalidade',tipo='text',nome='FINALIDADE DO DOCUMENTO',valor='',largura='470',mascara='',site='1',ordenacao='11',obrigatorio='0'
						WHERE id_servico_campo='575';
--26/05/2011 17:37:06
DELETE FROM vsites_servico_campo WHERE id_servico_campo = '' AND id_servico='29';
--26/05/2011 17:37:28
UPDATE vsites_servico SET dias='', status='Ativo', descricao='Breve Relato Completo', site='1',desc_site='Breve Relato Completo',servico_desc='',site_menu='1' WHERE id_servico='32';
--26/05/2011 17:37:28
UPDATE vsites_servico_campo SET campo='certidao_nome',tipo='text',nome='NOME',valor='',largura='470',mascara='',site='1',ordenacao='1',obrigatorio='1'
						WHERE id_servico_campo='736';
--26/05/2011 17:37:28
UPDATE vsites_servico_campo SET campo='certidao_estado',tipo='text',nome='ESTADO',valor='',largura='470',mascara='',site='1',ordenacao='2',obrigatorio='1'
						WHERE id_servico_campo='480';
--26/05/2011 17:37:28
UPDATE vsites_servico_campo SET campo='certidao_cidade',tipo='text',nome='CIDADE',valor='',largura='470',mascara='',site='1',ordenacao='3',obrigatorio='1'
						WHERE id_servico_campo='114';
--26/05/2011 17:37:28
UPDATE vsites_servico_campo SET campo='certidao_numero',tipo='text',nome='NÚMERO NIRE',valor='',largura='470',mascara='',site='1',ordenacao='4',obrigatorio='0'
						WHERE id_servico_campo='1333';
--26/05/2011 17:37:29
UPDATE vsites_servico_campo SET campo='certidao_endereco_empresa',tipo='text',nome='ENDERECO DA EMPRESA',valor='',largura='470',mascara='',site='1',ordenacao='5',obrigatorio='0'
						WHERE id_servico_campo='450';
--26/05/2011 17:37:29
UPDATE vsites_servico_campo SET campo='certidao_data',tipo='text',nome='ANO DA EMPRESA',valor='',largura='470',mascara='',site='1',ordenacao='6',obrigatorio='0'
						WHERE id_servico_campo='1332';
--26/05/2011 17:37:29
UPDATE vsites_servico_campo SET campo='certidao_cnpj',tipo='text',nome='CNPJ',valor='',largura='470',mascara='',site='1',ordenacao='7',obrigatorio='1'
						WHERE id_servico_campo='213';
--26/05/2011 17:37:29
UPDATE vsites_servico_campo SET campo='certidao_cpf',tipo='text',nome='CPF DO SÓCIO',valor='',largura='470',mascara='',site='0',ordenacao='8',obrigatorio='0'
						WHERE id_servico_campo='1547';
--26/05/2011 17:37:29
UPDATE vsites_servico_campo SET campo='certidao_protocolo',tipo='text',nome='PROTOCOLO',valor='',largura='470',mascara='',site='0',ordenacao='9',obrigatorio='0'
						WHERE id_servico_campo='965';
--26/05/2011 17:37:29
DELETE FROM vsites_servico_campo WHERE id_servico_campo = '' AND id_servico='32';
--26/05/2011 17:37:57
UPDATE vsites_servico SET dias='', status='Ativo', descricao='Negativa do IPTU (Tributos Imobiliários)', site='1',desc_site='Negativa do IPTU (Tributos Imobiliários)',servico_desc='',site_menu='1' WHERE id_servico='34';
--26/05/2011 17:37:57
UPDATE vsites_servico_campo SET campo='certidao_nome',tipo='text',nome='NOME',valor='',largura='470',mascara='',site='1',ordenacao='1',obrigatorio='1'
						WHERE id_servico_campo='788';
--26/05/2011 17:37:57
UPDATE vsites_servico_campo SET campo='certidao_estado',tipo='text',nome='ESTADO',valor='',largura='470',mascara='',site='1',ordenacao='2',obrigatorio='1'
						WHERE id_servico_campo='530';
--26/05/2011 17:37:57
UPDATE vsites_servico_campo SET campo='certidao_cidade',tipo='text',nome='CIDADE',valor='',largura='470',mascara='',site='1',ordenacao='3',obrigatorio='1'
						WHERE id_servico_campo='166';
--26/05/2011 17:37:57
UPDATE vsites_servico_campo SET campo='certidao_numero_contribuinte',tipo='text',nome='NUMERO DE CONTRIBUINTE',valor='',largura='470',mascara='',site='1',ordenacao='4',obrigatorio='1'
						WHERE id_servico_campo='840';
--26/05/2011 17:37:57
DELETE FROM vsites_servico_campo WHERE id_servico_campo = '' AND id_servico='34';
--26/05/2011 17:38:36
UPDATE vsites_servico SET dias='', status='Ativo', descricao='CND Receita Federal', site='1',desc_site='CND Receita Federal',servico_desc='',site_menu='1' WHERE id_servico='40';
--26/05/2011 17:38:36
UPDATE vsites_servico_campo SET campo='certidao_nome',tipo='text',nome='NOME',valor='',largura='470',mascara='',site='1',ordenacao='1',obrigatorio='1'
						WHERE id_servico_campo='749';
--26/05/2011 17:38:36
UPDATE vsites_servico_campo SET campo='certidao_cpf',tipo='text',nome='CPF',valor='',largura='470',mascara='',site='1',ordenacao='2',obrigatorio='0'
						WHERE id_servico_campo='299';
--26/05/2011 17:38:36
UPDATE vsites_servico_campo SET campo='certidao_cnpj',tipo='text',nome='CNPJ',valor='',largura='470',mascara='',site='1',ordenacao='3',obrigatorio='0'
						WHERE id_servico_campo='220';
--26/05/2011 17:38:36
UPDATE vsites_servico_campo SET campo='certidao_estado',tipo='text',nome='ESTADO',valor='',largura='470',mascara='',site='1',ordenacao='4',obrigatorio='1'
						WHERE id_servico_campo='491';
--26/05/2011 17:38:36
UPDATE vsites_servico_campo SET campo='certidao_cidade',tipo='text',nome='CIDADE',valor='',largura='470',mascara='',site='1',ordenacao='5',obrigatorio='1'
						WHERE id_servico_campo='126';
--26/05/2011 17:38:36
DELETE FROM vsites_servico_campo WHERE id_servico_campo = '' AND id_servico='40';
--26/05/2011 17:38:48
UPDATE vsites_servico SET dias='', status='Ativo', descricao='Cópia de Escritura ou Titulo Aquisitivo', site='1',desc_site='Cópia de Escritura ou Titulo Aquisitivo',servico_desc='',site_menu='1' WHERE id_servico='41';
--26/05/2011 17:38:48
UPDATE vsites_servico_campo SET campo='certidao_nome',tipo='text',nome='NOME',valor='',largura='470',mascara='',site='1',ordenacao='1',obrigatorio='1'
						WHERE id_servico_campo='753';
--26/05/2011 17:38:48
UPDATE vsites_servico_campo SET campo='certidao_rg',tipo='text',nome='RG',valor='',largura='470',mascara='',site='1',ordenacao='2',obrigatorio='0'
						WHERE id_servico_campo='1152';
--26/05/2011 17:38:48
UPDATE vsites_servico_campo SET campo='certidao_cpf',tipo='text',nome='CPF',valor='',largura='470',mascara='',site='1',ordenacao='3',obrigatorio='0'
						WHERE id_servico_campo='302';
--26/05/2011 17:38:48
UPDATE vsites_servico_campo SET campo='certidao_cnpj',tipo='text',nome='CNPJ',valor='',largura='470',mascara='',site='1',ordenacao='4',obrigatorio='0'
						WHERE id_servico_campo='223';
--26/05/2011 17:38:48
UPDATE vsites_servico_campo SET campo='certidao_estado',tipo='text',nome='ESTADO',valor='',largura='470',mascara='',site='1',ordenacao='5',obrigatorio='1'
						WHERE id_servico_campo='495';
--26/05/2011 17:38:48
UPDATE vsites_servico_campo SET campo='certidao_cidade',tipo='text',nome='CIDADE',valor='',largura='470',mascara='',site='1',ordenacao='6',obrigatorio='1'
						WHERE id_servico_campo='131';
--26/05/2011 17:38:48
UPDATE vsites_servico_campo SET campo='certidao_cartorio',tipo='text',nome='CARTORIO',valor='',largura='470',mascara='',site='1',ordenacao='7',obrigatorio='0'
						WHERE id_servico_campo='38';
--26/05/2011 17:38:48
UPDATE vsites_servico_campo SET campo='certidao_livro',tipo='text',nome='LIVRO',valor='',largura='470',mascara='',site='1',ordenacao='8',obrigatorio='0'
						WHERE id_servico_campo='620';
--26/05/2011 17:38:48
UPDATE vsites_servico_campo SET campo='certidao_folha',tipo='text',nome='FOLHA',valor='',largura='470',mascara='',site='1',ordenacao='9',obrigatorio='0'
						WHERE id_servico_campo='597';
--26/05/2011 17:38:48
UPDATE vsites_servico_campo SET campo='certidao_data',tipo='text',nome='DATA DA ESCRITURA',valor='',largura='470',mascara='',site='0',ordenacao='10',obrigatorio='0'
						WHERE id_servico_campo='1563';
--26/05/2011 17:38:48
DELETE FROM vsites_servico_campo WHERE id_servico_campo = '' AND id_servico='41';
--26/05/2011 17:38:56
UPDATE vsites_servico SET dias='', status='Ativo', descricao='Cópia do Contrato Social', site='1',desc_site='Cópia do Contrato Social',servico_desc='',site_menu='1' WHERE id_servico='42';
--26/05/2011 17:38:56
UPDATE vsites_servico_campo SET campo='certidao_nome',tipo='text',nome='NOME',valor='',largura='470',mascara='',site='1',ordenacao='1',obrigatorio='1'
						WHERE id_servico_campo='754';
--26/05/2011 17:38:56
UPDATE vsites_servico_campo SET campo='certidao_rg',tipo='text',nome='RG',valor='',largura='470',mascara='',site='1',ordenacao='2',obrigatorio='0'
						WHERE id_servico_campo='1153';
--26/05/2011 17:38:56
UPDATE vsites_servico_campo SET campo='certidao_cpf',tipo='text',nome='CPF',valor='',largura='470',mascara='',site='1',ordenacao='3',obrigatorio='0'
						WHERE id_servico_campo='303';
--26/05/2011 17:38:56
UPDATE vsites_servico_campo SET campo='certidao_cnpj',tipo='text',nome='CNPJ',valor='',largura='470',mascara='',site='1',ordenacao='4',obrigatorio='0'
						WHERE id_servico_campo='224';
--26/05/2011 17:38:56
UPDATE vsites_servico_campo SET campo='certidao_estado',tipo='text',nome='ESTADO',valor='',largura='470',mascara='',site='1',ordenacao='5',obrigatorio='1'
						WHERE id_servico_campo='496';
--26/05/2011 17:38:56
UPDATE vsites_servico_campo SET campo='certidao_cidade',tipo='text',nome='CIDADE',valor='',largura='470',mascara='',site='1',ordenacao='6',obrigatorio='1'
						WHERE id_servico_campo='132';
--26/05/2011 17:38:56
UPDATE vsites_servico_campo SET campo='certidao_cartorio',tipo='text',nome='CARTORIO',valor='',largura='470',mascara='',site='1',ordenacao='7',obrigatorio='0'
						WHERE id_servico_campo='39';
--26/05/2011 17:38:56
UPDATE vsites_servico_campo SET campo='certidao_protocolo',tipo='text',nome='PROTOCOLO',valor='',largura='470',mascara='',site='0',ordenacao='8',obrigatorio='0'
						WHERE id_servico_campo='977';
--26/05/2011 17:38:56
DELETE FROM vsites_servico_campo WHERE id_servico_campo = '' AND id_servico='42';
--26/05/2011 17:39:31
UPDATE vsites_servico SET dias='', status='Ativo', descricao='Limpeza de Nome', site='',desc_site='',servico_desc='',site_menu='' WHERE id_servico='48';
--26/05/2011 17:39:31
UPDATE vsites_servico_campo SET campo='certidao_nome',tipo='text',nome='NOME',valor='',largura='470',mascara='',site='1',ordenacao='1',obrigatorio='1'
						WHERE id_servico_campo='783';
--26/05/2011 17:39:31
UPDATE vsites_servico_campo SET campo='certidao_rg',tipo='text',nome='RG',valor='',largura='470',mascara='',site='1',ordenacao='2',obrigatorio='0'
						WHERE id_servico_campo='1179';
--26/05/2011 17:39:31
UPDATE vsites_servico_campo SET campo='certidao_orgao_emissor',tipo='text',nome='ORGAO EMISSOR',valor='',largura='470',mascara='',site='1',ordenacao='3',obrigatorio='0'
						WHERE id_servico_campo='896';
--26/05/2011 17:39:31
UPDATE vsites_servico_campo SET campo='certidao_data_expedicao',tipo='text',nome='DATA DE EXPEDICAO',valor='',largura='470',mascara='',site='1',ordenacao='4',obrigatorio='0'
						WHERE id_servico_campo='378';
--26/05/2011 17:39:31
UPDATE vsites_servico_campo SET campo='certidao_cpf',tipo='text',nome='CPF',valor='',largura='470',mascara='',site='1',ordenacao='5',obrigatorio='0'
						WHERE id_servico_campo='326';
--26/05/2011 17:39:31
UPDATE vsites_servico_campo SET campo='certidao_cnpj',tipo='text',nome='CNPJ',valor='',largura='470',mascara='',site='1',ordenacao='6',obrigatorio='0'
						WHERE id_servico_campo='240';
--26/05/2011 17:39:31
UPDATE vsites_servico_campo SET campo='certidao_estado',tipo='text',nome='ESTADO',valor='',largura='470',mascara='',site='1',ordenacao='7',obrigatorio='1'
						WHERE id_servico_campo='523';
--26/05/2011 17:39:31
UPDATE vsites_servico_campo SET campo='certidao_cidade',tipo='text',nome='CIDADE',valor='',largura='470',mascara='',site='1',ordenacao='8',obrigatorio='1'
						WHERE id_servico_campo='158';
--26/05/2011 17:39:31
UPDATE vsites_servico_campo SET campo='certidao_cartorio',tipo='text',nome='CARTORIO',valor='',largura='470',mascara='',site='1',ordenacao='9',obrigatorio='0'
						WHERE id_servico_campo='50';
--26/05/2011 17:39:31
UPDATE vsites_servico_campo SET campo='certidao_protocolo',tipo='text',nome='PROTOCOLO',valor='',largura='470',mascara='',site='0',ordenacao='10',obrigatorio='0'
						WHERE id_servico_campo='997';
--26/05/2011 17:39:31
DELETE FROM vsites_servico_campo WHERE id_servico_campo = '' AND id_servico='48';
--26/05/2011 17:39:50
UPDATE vsites_servico SET dias='', status='Ativo', descricao='Levantamento de Débitos do ISS', site='1',desc_site='Levantamento de Débitos do ISS',servico_desc='',site_menu='1' WHERE id_servico='51';
--26/05/2011 17:39:50
UPDATE vsites_servico_campo SET campo='certidao_nome',tipo='text',nome='NOME',valor='',largura='470',mascara='',site='1',ordenacao='1',obrigatorio='1'
						WHERE id_servico_campo='782';
--26/05/2011 17:39:50
UPDATE vsites_servico_campo SET campo='certidao_rg',tipo='text',nome='RG',valor='',largura='470',mascara='',site='1',ordenacao='2',obrigatorio='0'
						WHERE id_servico_campo='1571';
--26/05/2011 17:39:50
UPDATE vsites_servico_campo SET campo='certidao_orgao_emissor',tipo='text',nome='ORGÃO EMISSOR',valor='',largura='470',mascara='',site='1',ordenacao='3',obrigatorio='0'
						WHERE id_servico_campo='1572';
--26/05/2011 17:39:50
UPDATE vsites_servico_campo SET campo='certidao_data_expedicao',tipo='text',nome='DATA DA EXPEDIÇÃO ',valor='',largura='470',mascara='',site='0',ordenacao='4',obrigatorio='0'
						WHERE id_servico_campo='1573';
--26/05/2011 17:39:50
UPDATE vsites_servico_campo SET campo='certidao_cpf',tipo='text',nome='CPF',valor='',largura='470',mascara='',site='1',ordenacao='5',obrigatorio='0'
						WHERE id_servico_campo='1574';
--26/05/2011 17:39:50
UPDATE vsites_servico_campo SET campo='certidao_cnpj',tipo='text',nome='CNPJ',valor='',largura='470',mascara='',site='1',ordenacao='6',obrigatorio='0'
						WHERE id_servico_campo='239';
--26/05/2011 17:39:50
UPDATE vsites_servico_campo SET campo='certidao_estado',tipo='text',nome='ESTADO',valor='',largura='470',mascara='',site='1',ordenacao='7',obrigatorio='1'
						WHERE id_servico_campo='522';
--26/05/2011 17:39:50
UPDATE vsites_servico_campo SET campo='certidao_cidade',tipo='text',nome='CIDADE',valor='',largura='470',mascara='',site='1',ordenacao='8',obrigatorio='1'
						WHERE id_servico_campo='157';
--26/05/2011 17:39:50
DELETE FROM vsites_servico_campo WHERE id_servico_campo = '' AND id_servico='51';
--26/05/2011 17:40:22
UPDATE vsites_servico SET dias='', status='Ativo', descricao='Tributos Estaduais', site='1',desc_site='Tributos Estaduais',servico_desc='',site_menu='1' WHERE id_servico='52';
--26/05/2011 17:40:22
UPDATE vsites_servico_campo SET campo='certidao_nome',tipo='text',nome='NOME',valor='',largura='470',mascara='',site='1',ordenacao='1',obrigatorio='1'
						WHERE id_servico_campo='814';
--26/05/2011 17:40:22
UPDATE vsites_servico_campo SET campo='certidao_rg',tipo='text',nome='RG',valor='',largura='470',mascara='',site='1',ordenacao='2',obrigatorio='0'
						WHERE id_servico_campo='1203';
--26/05/2011 17:40:22
UPDATE vsites_servico_campo SET campo='certidao_cpf',tipo='text',nome='CPF',valor='',largura='470',mascara='',site='1',ordenacao='3',obrigatorio='0'
						WHERE id_servico_campo='349';
--26/05/2011 17:40:22
UPDATE vsites_servico_campo SET campo='certidao_cnpj',tipo='text',nome='CNPJ',valor='',largura='470',mascara='',site='1',ordenacao='4',obrigatorio='0'
						WHERE id_servico_campo='262';
--26/05/2011 17:40:22
UPDATE vsites_servico_campo SET campo='certidao_estado',tipo='text',nome='ESTADO',valor='',largura='470',mascara='',site='1',ordenacao='5',obrigatorio='1'
						WHERE id_servico_campo='559';
--26/05/2011 17:40:22
UPDATE vsites_servico_campo SET campo='certidao_cidade',tipo='text',nome='CIDADE',valor='',largura='470',mascara='',site='1',ordenacao='6',obrigatorio='1'
						WHERE id_servico_campo='195';
--26/05/2011 17:40:22
DELETE FROM vsites_servico_campo WHERE id_servico_campo = '' AND id_servico='52';
--26/05/2011 17:41:51
UPDATE vsites_servico SET dias='', status='Ativo', descricao='Retirada de Boleto I T B I', site='1',desc_site='Retirada de Boleto I T B I',servico_desc='',site_menu='1' WHERE id_servico='53';
--26/05/2011 17:41:51
UPDATE vsites_servico_campo SET campo='certidao_nome',tipo='text',nome='NOME',valor='',largura='470',mascara='',site='1',ordenacao='1',obrigatorio='1'
						WHERE id_servico_campo='808';
--26/05/2011 17:41:51
UPDATE vsites_servico_campo SET campo='certidao_rg',tipo='text',nome='RG',valor='',largura='470',mascara='',site='1',ordenacao='2',obrigatorio='0'
						WHERE id_servico_campo='1197';
--26/05/2011 17:41:51
UPDATE vsites_servico_campo SET campo='certidao_data_expedicao',tipo='text',nome='DATA DE EXPEDICAO',valor='',largura='470',mascara='',site='1',ordenacao='3',obrigatorio='0'
						WHERE id_servico_campo='380';
--26/05/2011 17:41:51
UPDATE vsites_servico_campo SET campo='certidao_orgao_emissor',tipo='text',nome='ORGAO EMISSOR',valor='',largura='470',mascara='',site='1',ordenacao='4',obrigatorio='0'
						WHERE id_servico_campo='899';
--26/05/2011 17:41:51
UPDATE vsites_servico_campo SET campo='certidao_cpf',tipo='text',nome='CPF',valor='',largura='470',mascara='',site='1',ordenacao='5',obrigatorio='0'
						WHERE id_servico_campo='343';
--26/05/2011 17:41:51
UPDATE vsites_servico_campo SET campo='certidao_cnpj',tipo='text',nome='CNPJ',valor='',largura='470',mascara='',site='1',ordenacao='6',obrigatorio='0'
						WHERE id_servico_campo='257';
--26/05/2011 17:41:51
UPDATE vsites_servico_campo SET campo='certidao_estado',tipo='text',nome='ESTADO',valor='',largura='470',mascara='',site='1',ordenacao='7',obrigatorio='1'
						WHERE id_servico_campo='550';
--26/05/2011 17:41:51
UPDATE vsites_servico_campo SET campo='certidao_cidade',tipo='text',nome='CIDADE',valor='',largura='470',mascara='',site='1',ordenacao='8',obrigatorio='1'
						WHERE id_servico_campo='186';
--26/05/2011 17:41:51
UPDATE vsites_servico_campo SET campo='certidao_cartorio',tipo='text',nome='CARTORIO',valor='',largura='470',mascara='',site='1',ordenacao='9',obrigatorio='0'
						WHERE id_servico_campo='71';
--26/05/2011 17:41:51
UPDATE vsites_servico_campo SET campo='certidao_protocolo',tipo='text',nome='PROTOCOLO',valor='',largura='470',mascara='',site='0',ordenacao='10',obrigatorio='0'
						WHERE id_servico_campo='1021';
--26/05/2011 17:41:51
DELETE FROM vsites_servico_campo WHERE id_servico_campo = '' AND id_servico='53';
--26/05/2011 17:42:23
UPDATE vsites_servico SET dias='', status='Ativo', descricao='Baixa de Hipoteca', site='1',desc_site='Baixa de Hipoteca',servico_desc='',site_menu='1' WHERE id_servico='55';
--26/05/2011 17:42:23
UPDATE vsites_servico_campo SET campo='certidao_nome',tipo='text',nome='NOME',valor='',largura='470',mascara='',site='1',ordenacao='1',obrigatorio='0'
						WHERE id_servico_campo='733';
--26/05/2011 17:42:23
UPDATE vsites_servico_campo SET campo='certidao_estado',tipo='text',nome='ESTADO',valor='',largura='470',mascara='',site='1',ordenacao='2',obrigatorio='0'
						WHERE id_servico_campo='476';
--26/05/2011 17:42:23
UPDATE vsites_servico_campo SET campo='certidao_cidade',tipo='text',nome='CIDADE',valor='',largura='470',mascara='',site='1',ordenacao='3',obrigatorio='0'
						WHERE id_servico_campo='110';
--26/05/2011 17:42:23
UPDATE vsites_servico_campo SET campo='certidao_cartorio',tipo='text',nome='CARTORIO',valor='',largura='470',mascara='',site='1',ordenacao='4',obrigatorio='0'
						WHERE id_servico_campo='29';
--26/05/2011 17:42:23
UPDATE vsites_servico_campo SET campo='certidao_protocolo',tipo='text',nome='PROTOCOLO',valor='',largura='470',mascara='',site='0',ordenacao='5',obrigatorio='0'
						WHERE id_servico_campo='964';
--26/05/2011 17:42:23
UPDATE vsites_servico_campo SET campo='certidao_cnpj',tipo='text',nome='CNPJ',valor='',largura='470',mascara='',site='1',ordenacao='6',obrigatorio='0'
						WHERE id_servico_campo='211';
--26/05/2011 17:42:23
UPDATE vsites_servico_campo SET campo='certidao_cpf',tipo='text',nome='CPF',valor='',largura='470',mascara='',site='1',ordenacao='7',obrigatorio='0'
						WHERE id_servico_campo='289';
--26/05/2011 17:42:23
UPDATE vsites_servico_campo SET campo='certidao_rg',tipo='text',nome='RG',valor='',largura='470',mascara='',site='1',ordenacao='8',obrigatorio='0'
						WHERE id_servico_campo='1140';
--26/05/2011 17:42:23
DELETE FROM vsites_servico_campo WHERE id_servico_campo = '' AND id_servico='55';
--26/05/2011 17:42:53
UPDATE vsites_servico SET dias='', status='Ativo', descricao='FGTS', site='1',desc_site='FGTS',servico_desc='',site_menu='1' WHERE id_servico='60';
--26/05/2011 17:42:53
UPDATE vsites_servico_campo SET campo='certidao_nome',tipo='text',nome='NOME',valor='',largura='470',mascara='',site='1',ordenacao='1',obrigatorio='1'
						WHERE id_servico_campo='770';
--26/05/2011 17:42:53
UPDATE vsites_servico_campo SET campo='certidao_estado',tipo='text',nome='ESTADO',valor='',largura='470',mascara='',site='1',ordenacao='2',obrigatorio='1'
						WHERE id_servico_campo='511';
--26/05/2011 17:42:53
UPDATE vsites_servico_campo SET campo='certidao_cidade',tipo='text',nome='CIDADE',valor='',largura='470',mascara='',site='1',ordenacao='3',obrigatorio='1'
						WHERE id_servico_campo='147';
--26/05/2011 17:42:54
UPDATE vsites_servico_campo SET campo='certidao_cnpj',tipo='text',nome='CNPJ',valor='',largura='470',mascara='',site='1',ordenacao='4',obrigatorio='1'
						WHERE id_servico_campo='234';
--26/05/2011 17:42:54
DELETE FROM vsites_servico_campo WHERE id_servico_campo = '' AND id_servico='60';
--13/06/2011 09:44:47
UPDATE vsites_servico SET dias='', status='Ativo', descricao='Nascimento', site='1',desc_site='Certidão de Nascimento (2ª via)',servico_desc='<P>
Realizamos a busca da 2º via de Certidão de Nascimento em todo território nacional.
</P>
',site_menu='1' WHERE id_servico='2';
--13/06/2011 09:44:47
UPDATE vsites_servico_campo SET campo='certidao_nome',tipo='text',nome='NOME',valor='',largura='470',mascara='',site='1',ordenacao='1',obrigatorio='1'
						WHERE id_servico_campo='785';
--13/06/2011 09:44:47
UPDATE vsites_servico_campo SET campo='certidao_pai',tipo='text',nome='PAI',valor='',largura='470',mascara='',site='1',ordenacao='2',obrigatorio='0'
						WHERE id_servico_campo='921';
--13/06/2011 09:44:47
UPDATE vsites_servico_campo SET campo='certidao_mae',tipo='text',nome='MAE',valor='',largura='470',mascara='',site='1',ordenacao='3',obrigatorio='1'
						WHERE id_servico_campo='655';
--13/06/2011 09:44:47
UPDATE vsites_servico_campo SET campo='certidao_data_nascimento',tipo='text',nome='DATA DE NASCIMENTO',valor='',largura='470',mascara='',site='1',ordenacao='4',obrigatorio='1'
						WHERE id_servico_campo='404';
--13/06/2011 09:44:47
UPDATE vsites_servico_campo SET campo='certidao_livro',tipo='text',nome='LIVRO',valor='',largura='470',mascara='',site='1',ordenacao='5',obrigatorio='0'
						WHERE id_servico_campo='627';
--13/06/2011 09:44:47
UPDATE vsites_servico_campo SET campo='certidao_folha',tipo='text',nome='FOLHA',valor='',largura='470',mascara='',site='1',ordenacao='6',obrigatorio='0'
						WHERE id_servico_campo='605';
--13/06/2011 09:44:47
UPDATE vsites_servico_campo SET campo='certidao_registro',tipo='text',nome='REGISTRO',valor='',largura='470',mascara='',site='1',ordenacao='7',obrigatorio='0'
						WHERE id_servico_campo='1050';
--13/06/2011 09:44:47
UPDATE vsites_servico_campo SET campo='certidao_estado',tipo='text',nome='ESTADO',valor='',largura='470',mascara='',site='1',ordenacao='8',obrigatorio='1'
						WHERE id_servico_campo='527';
--13/06/2011 09:44:47
UPDATE vsites_servico_campo SET campo='certidao_cidade',tipo='text',nome='CIDADE',valor='',largura='470',mascara='',site='1',ordenacao='9',obrigatorio='1'
						WHERE id_servico_campo='163';
--13/06/2011 09:44:47
UPDATE vsites_servico_campo SET campo='certidao_cartorio',tipo='text',nome='CARTORIO',valor='',largura='470',mascara='',site='1',ordenacao='10',obrigatorio='0'
						WHERE id_servico_campo='54';
--13/06/2011 09:44:47
UPDATE vsites_servico_campo SET campo='certidao_cartorio_cep',tipo='text',nome='CEP DO CARTORIO',valor='',largura='470',mascara='',site='1',ordenacao='11',obrigatorio='0'
						WHERE id_servico_campo='98';
--13/06/2011 09:44:47
UPDATE vsites_servico_campo SET campo='certidao_data_registro',tipo='text',nome='DATA DO REGISTRO',valor='',largura='470',mascara='',site='1',ordenacao='12',obrigatorio='0'
						WHERE id_servico_campo='423';
--13/06/2011 09:44:47
UPDATE vsites_servico_campo SET campo='certidao_protocolo',tipo='text',nome='PROTOCOLO',valor='',largura='470',mascara='',site='0',ordenacao='13',obrigatorio='0'
						WHERE id_servico_campo='1001';
--13/06/2011 09:44:47
UPDATE vsites_servico_campo SET campo='certidao_averbacao',tipo='text',nome='AVERBACAO',valor='',largura='470',mascara='',site='1',ordenacao='14',obrigatorio='0'
						WHERE id_servico_campo='11';
--13/06/2011 09:44:47
UPDATE vsites_servico_campo SET campo='certidao_finalidade',tipo='text',nome='FINALIDADE DO DOCUMENTO',valor='',largura='470',mascara='',site='1',ordenacao='15',obrigatorio='0'
						WHERE id_servico_campo='584';
--13/06/2011 09:44:47
UPDATE vsites_servico_campo SET campo='certidao_tem_copia_doc',tipo='text',nome='TEM COPIA DO DOCUMENTO',valor='',largura='470',mascara='',site='1',ordenacao='16',obrigatorio='0'
						WHERE id_servico_campo='1228';
--13/06/2011 09:44:47
DELETE FROM vsites_servico_campo WHERE id_servico_campo = '' AND id_servico='2';
--13/06/2011 09:51:29
UPDATE vsites_servico SET dias='', status='Ativo', descricao='Certidão de Matrícula Atualizada com Negativa de Ônus e Citações de Ações Reipersecutórias', site='1',desc_site='Certidão de Matrícula Atualizada com Negativa de Ônus e Citações de Ações ReiperCertidão de Matrícula Atualizada com Negativa de Ônus e Citações de Ações Reipersecutórias',servico_desc='<p>
Além de constar a descrição do imóvel, seus ônus e a qualificação do proprietário, consta também qualquer ação reipersecutória que pesar sobre o imóvel.
</p>',site_menu='' WHERE id_servico='157';
--13/06/2011 09:51:29
UPDATE vsites_servico_campo SET campo='certidao_cartorio',tipo='text',nome='CARTÓRIO',valor='',largura='470',mascara='',site='1',ordenacao='1',obrigatorio='1'
						WHERE id_servico_campo='1384';
--13/06/2011 09:51:29
UPDATE vsites_servico_campo SET campo='certidao_matricula',tipo='text',nome='MATRÍCULA',valor='',largura='470',mascara='',site='1',ordenacao='2',obrigatorio='1'
						WHERE id_servico_campo='1385';
--13/06/2011 09:51:29
UPDATE vsites_servico_campo SET campo='certidao_estado',tipo='text',nome='UF',valor='',largura='470',mascara='',site='1',ordenacao='3',obrigatorio='1'
						WHERE id_servico_campo='1387';
--13/06/2011 09:51:29
UPDATE vsites_servico_campo SET campo='certidao_cidade',tipo='text',nome='CIDADE',valor='',largura='470',mascara='',site='1',ordenacao='4',obrigatorio='1'
						WHERE id_servico_campo='1386';
--13/06/2011 09:51:29
DELETE FROM vsites_servico_campo WHERE id_servico_campo = '' AND id_servico='157';
--13/06/2011 09:54:08
UPDATE vsites_servico SET dias='', status='Ativo', descricao='Certidão Trintenária com Negativa de Ônus', site='1',desc_site='Certidão Trintenária com Negativa de Ônus',servico_desc='<p>
São certidões de matriculas que correspondem a um período de quinze (30) anos, informando que não existe nenhum ato registrado na matricula deste que impeça ou dificulte a sua venda.
</p>',site_menu='' WHERE id_servico='165';
--13/06/2011 09:54:08
UPDATE vsites_servico_campo SET campo='certidao_cartorio',tipo='text',nome='CARTÓRIO',valor='',largura='470',mascara='',site='1',ordenacao='1',obrigatorio='1'
						WHERE id_servico_campo='1416';
--13/06/2011 09:54:08
UPDATE vsites_servico_campo SET campo='certidao_matricula',tipo='text',nome='MATRÍCULA',valor='',largura='470',mascara='',site='1',ordenacao='2',obrigatorio='1'
						WHERE id_servico_campo='1417';
--13/06/2011 09:54:08
UPDATE vsites_servico_campo SET campo='certidao_estado',tipo='text',nome='UF',valor='',largura='470',mascara='',site='1',ordenacao='3',obrigatorio='1'
						WHERE id_servico_campo='1419';
--13/06/2011 09:54:08
UPDATE vsites_servico_campo SET campo='certidao_cidade',tipo='text',nome='CIDADE',valor='',largura='470',mascara='',site='1',ordenacao='4',obrigatorio='1'
						WHERE id_servico_campo='1418';
--13/06/2011 09:54:08
DELETE FROM vsites_servico_campo WHERE id_servico_campo = '' AND id_servico='165';
--13/06/2011 09:54:32
UPDATE vsites_servico SET dias='', status='Ativo', descricao='Certidão Trintenária com Negativa de Ônus e Citações de Ações Reipersecutórias', site='1',desc_site='Certidão Trintenária com Negativa de Ônus e Citações de Ações Reipersecutórias',servico_desc='<p>
São certidões de matriculas que correspondem a um período de quinze (30) anos, informando que não existe nenhum ato registrado na matricula deste que impeça ou dificulte a sua venda,correspondendo a uma obrigação assumida anteriormente pelo réu, de dar, fazer, sobre determindado imóvel.
</p>
',site_menu='' WHERE id_servico='166';
--13/06/2011 09:54:32
UPDATE vsites_servico_campo SET campo='certidao_cartorio',tipo='text',nome='CARTÓRIO',valor='',largura='470',mascara='',site='1',ordenacao='1',obrigatorio='1'
						WHERE id_servico_campo='1420';
--13/06/2011 09:54:32
UPDATE vsites_servico_campo SET campo='certidao_matricula',tipo='text',nome='MATRÍCULA',valor='',largura='470',mascara='',site='1',ordenacao='2',obrigatorio='1'
						WHERE id_servico_campo='1421';
--13/06/2011 09:54:32
UPDATE vsites_servico_campo SET campo='certidao_estado',tipo='text',nome='UF',valor='',largura='470',mascara='',site='1',ordenacao='3',obrigatorio='1'
						WHERE id_servico_campo='1423';
--13/06/2011 09:54:32
UPDATE vsites_servico_campo SET campo='certidao_cidade',tipo='text',nome='CIDADE',valor='',largura='470',mascara='',site='1',ordenacao='4',obrigatorio='1'
						WHERE id_servico_campo='1422';
--13/06/2011 09:54:32
DELETE FROM vsites_servico_campo WHERE id_servico_campo = '' AND id_servico='166';
--13/06/2011 10:19:09
UPDATE vsites_servico SET dias='', status='Ativo', descricao='Inteiro Teor - Casamento', site='1',desc_site='Certidão Inteiro Teor - Casamento',servico_desc='<P>
A certidão de Casamento de inteiro teor é uma certidão que possui a transcrição completa do livro de registros, ou seja, ali constam todas as informações sobre seu Casamento como quem os registrou, quais foram as testemunhas de registro (se houver) e outros dados. Por isso sempre que for solicitar uma segunda via de certidão de Casamento, não esqueça de informar que você precisa de uma certidão de Casamento de inteiro teor. Caso contrário, você receberá a versão resumida.
</P>',site_menu='1' WHERE id_servico='10';
--13/06/2011 10:19:09
UPDATE vsites_servico_campo SET campo='certidao_nome',tipo='text',nome='NOME',valor='',largura='470',mascara='',site='1',ordenacao='1',obrigatorio='1'
						WHERE id_servico_campo='772';
--13/06/2011 10:19:09
UPDATE vsites_servico_campo SET campo='certidao_esposa',tipo='text',nome='ESPOSA/ESPOSO',valor='',largura='470',mascara='',site='1',ordenacao='2',obrigatorio='1'
						WHERE id_servico_campo='465';
--13/06/2011 10:19:09
UPDATE vsites_servico_campo SET campo='certidao_data_casamento',tipo='text',nome='DATA DE CASAMENTO',valor='',largura='470',mascara='',site='1',ordenacao='3',obrigatorio='1'
						WHERE id_servico_campo='365';
--13/06/2011 10:19:09
UPDATE vsites_servico_campo SET campo='certidao_livro',tipo='text',nome='LIVRO',valor='',largura='470',mascara='',site='1',ordenacao='4',obrigatorio='0'
						WHERE id_servico_campo='624';
--13/06/2011 10:19:09
UPDATE vsites_servico_campo SET campo='certidao_folha',tipo='text',nome='FOLHA',valor='',largura='470',mascara='',site='1',ordenacao='5',obrigatorio='0'
						WHERE id_servico_campo='602';
--13/06/2011 10:19:09
UPDATE vsites_servico_campo SET campo='certidao_registro',tipo='text',nome='REGISTRO',valor='',largura='470',mascara='',site='1',ordenacao='6',obrigatorio='0'
						WHERE id_servico_campo='1047';
--13/06/2011 10:19:09
UPDATE vsites_servico_campo SET campo='certidao_estado',tipo='text',nome='ESTADO',valor='',largura='470',mascara='',site='1',ordenacao='7',obrigatorio='1'
						WHERE id_servico_campo='512';
--13/06/2011 10:19:09
UPDATE vsites_servico_campo SET campo='certidao_cidade',tipo='text',nome='CIDADE',valor='',largura='470',mascara='',site='1',ordenacao='8',obrigatorio='1'
						WHERE id_servico_campo='148';
--13/06/2011 10:19:10
UPDATE vsites_servico_campo SET campo='certidao_averbacao',tipo='text',nome='AVERBACAO',valor='',largura='470',mascara='',site='1',ordenacao='9',obrigatorio='0'
						WHERE id_servico_campo='8';
--13/06/2011 10:19:10
UPDATE vsites_servico_campo SET campo='certidao_cartorio',tipo='text',nome='CARTORIO',valor='',largura='470',mascara='',site='1',ordenacao='10',obrigatorio='0'
						WHERE id_servico_campo='47';
--13/06/2011 10:19:10
UPDATE vsites_servico_campo SET campo='certidao_finalidade',tipo='text',nome='FINALIDADE DO DOCUMENTO',valor='',largura='470',mascara='',site='1',ordenacao='11',obrigatorio='0'
						WHERE id_servico_campo='581';
--13/06/2011 10:19:10
DELETE FROM vsites_servico_campo WHERE id_servico_campo = '' AND id_servico='10';
--13/06/2011 10:32:16
UPDATE vsites_servico SET dias='', status='Ativo', descricao='Distribuidor Civel', site='1',desc_site='Distribuidor Civel',servico_desc='<p>
Certidão emitida averiguando se constam ou não, ações cíveis.
Exemplos: Separação, divorcio, condomínio, despejo, cobrança etc. Solicita-se normalmente para compra e venda de imóvel.
Documentos necessários para solicitação; Pessoa Física; Informar nome completo, RG, CPF e para qual finalidade é a certidão. Pessoa Jurídica: Informar nome completo, CNPJ e para qual finalidade é a certidão.  
</P>',site_menu='1' WHERE id_servico='6';
--13/06/2011 10:32:16
UPDATE vsites_servico_campo SET campo='certidao_nome',tipo='text',nome='NOME',valor='',largura='470',mascara='',site='1',ordenacao='1',obrigatorio='1'
						WHERE id_servico_campo='766';
--13/06/2011 10:32:16
UPDATE vsites_servico_campo SET campo='certidao_rg',tipo='text',nome='RG',valor='',largura='470',mascara='',site='1',ordenacao='2',obrigatorio='0'
						WHERE id_servico_campo='1164';
--13/06/2011 10:32:16
UPDATE vsites_servico_campo SET campo='certidao_cpf',tipo='text',nome='CPF',valor='',largura='470',mascara='',site='1',ordenacao='3',obrigatorio='0'
						WHERE id_servico_campo='312';
--13/06/2011 10:32:17
UPDATE vsites_servico_campo SET campo='certidao_cnpj',tipo='text',nome='CNPJ',valor='',largura='470',mascara='',site='1',ordenacao='4',obrigatorio='0'
						WHERE id_servico_campo='230';
--13/06/2011 10:32:17
UPDATE vsites_servico_campo SET campo='certidao_estado',tipo='text',nome='ESTADO',valor='',largura='470',mascara='',site='1',ordenacao='5',obrigatorio='1'
						WHERE id_servico_campo='505';
--13/06/2011 10:32:17
UPDATE vsites_servico_campo SET campo='certidao_cidade',tipo='text',nome='CIDADE',valor='',largura='470',mascara='',site='1',ordenacao='6',obrigatorio='1'
						WHERE id_servico_campo='141';
--13/06/2011 10:32:17
UPDATE vsites_servico_campo SET campo='certidao_protocolo',tipo='text',nome='PROTOCOLO',valor='',largura='470',mascara='',site='0',ordenacao='7',obrigatorio='0'
						WHERE id_servico_campo='985';
--13/06/2011 10:32:17
DELETE FROM vsites_servico_campo WHERE id_servico_campo = '' AND id_servico='6';
--13/06/2011 10:33:29
UPDATE vsites_servico SET dias='', status='Ativo', descricao='Executivos Fiscais', site='1',desc_site='Executivos Fiscais',servico_desc='<p>
Certidão emitida averiguando se constam ou não, processos de ações de execuções fiscais. Documentos necessários para solicitação; Pessoa Física: Informar nome completo, RG, CPF e para qual finalidade é a certidão. Pessoa Jurídica: Informar nome completo, CNPJ e para qual finalidade é a certidão.
</p>',site_menu='1' WHERE id_servico='7';
--13/06/2011 10:33:29
UPDATE vsites_servico_campo SET campo='certidao_nome',tipo='text',nome='NOME',valor='',largura='470',mascara='',site='1',ordenacao='1',obrigatorio='1'
						WHERE id_servico_campo='768';
--13/06/2011 10:33:29
UPDATE vsites_servico_campo SET campo='certidao_rg',tipo='text',nome='RG',valor='',largura='470',mascara='',site='1',ordenacao='2',obrigatorio='0'
						WHERE id_servico_campo='1167';
--13/06/2011 10:33:29
UPDATE vsites_servico_campo SET campo='certidao_cpf',tipo='text',nome='CPF',valor='',largura='470',mascara='',site='1',ordenacao='3',obrigatorio='0'
						WHERE id_servico_campo='315';
--13/06/2011 10:33:29
UPDATE vsites_servico_campo SET campo='certidao_cnpj',tipo='text',nome='CNPJ',valor='',largura='470',mascara='',site='1',ordenacao='4',obrigatorio='0'
						WHERE id_servico_campo='232';
--13/06/2011 10:33:29
UPDATE vsites_servico_campo SET campo='certidao_estado',tipo='text',nome='ESTADO',valor='',largura='470',mascara='',site='1',ordenacao='5',obrigatorio='1'
						WHERE id_servico_campo='508';
--13/06/2011 10:33:29
UPDATE vsites_servico_campo SET campo='certidao_cidade',tipo='text',nome='CIDADE',valor='',largura='470',mascara='',site='1',ordenacao='6',obrigatorio='1'
						WHERE id_servico_campo='144';
--13/06/2011 10:33:29
UPDATE vsites_servico_campo SET campo='certidao_finalidade',tipo='text',nome='FINALIDADE',valor='',largura='470',mascara='',site='0',ordenacao='7',obrigatorio='0'
						WHERE id_servico_campo='1558';
--13/06/2011 10:33:29
UPDATE vsites_servico_campo SET campo='certidao_protocolo',tipo='text',nome='PROTOCOLO',valor='',largura='470',mascara='',site='0',ordenacao='8',obrigatorio='1'
						WHERE id_servico_campo='1559';
--13/06/2011 10:33:29
DELETE FROM vsites_servico_campo WHERE id_servico_campo = '' AND id_servico='7';
--13/06/2011 10:33:58
UPDATE vsites_servico SET dias='', status='Ativo', descricao='Justiça Federal', site='1',desc_site='Justiça Federal',servico_desc='<P>
Cumpre a mesma finalidade da certidão extraída no distribuidor cível porém abrange as ações na esfera federal.
Documentos necessários para dar entrada na solicitação; 
Pessoa Física: Nome completo, CPF, RG, Cidade, Estado.
Pessoa Jurídica: Nome completo, CNPJ, Cidade, Estado.
</p>',site_menu='1' WHERE id_servico='8';
--13/06/2011 10:33:58
UPDATE vsites_servico_campo SET campo='certidao_nome',tipo='text',nome='NOME',valor='',largura='470',mascara='',site='1',ordenacao='1',obrigatorio='1'
						WHERE id_servico_campo='778';
--13/06/2011 10:33:58
UPDATE vsites_servico_campo SET campo='certidao_rg',tipo='text',nome='RG',valor='',largura='470',mascara='',site='1',ordenacao='2',obrigatorio='0'
						WHERE id_servico_campo='1175';
--13/06/2011 10:33:58
UPDATE vsites_servico_campo SET campo='certidao_cpf',tipo='text',nome='CPF',valor='',largura='470',mascara='',site='1',ordenacao='3',obrigatorio='0'
						WHERE id_servico_campo='323';
--13/06/2011 10:33:58
UPDATE vsites_servico_campo SET campo='certidao_cnpj',tipo='text',nome='CNPJ',valor='',largura='470',mascara='',site='1',ordenacao='4',obrigatorio='0'
						WHERE id_servico_campo='237';
--13/06/2011 10:33:58
UPDATE vsites_servico_campo SET campo='certidao_estado',tipo='text',nome='ESTADO',valor='',largura='470',mascara='',site='1',ordenacao='5',obrigatorio='1'
						WHERE id_servico_campo='518';
--13/06/2011 10:33:58
UPDATE vsites_servico_campo SET campo='certidao_cidade',tipo='text',nome='CIDADE',valor='',largura='470',mascara='',site='1',ordenacao='6',obrigatorio='1'
						WHERE id_servico_campo='154';
--13/06/2011 10:33:58
DELETE FROM vsites_servico_campo WHERE id_servico_campo = '' AND id_servico='8';
--14/06/2011 14:28:32
UPDATE vsites_servico SET dias='', status='Inativo', descricao='Rodobens', site='1',desc_site='',servico_desc='',site_menu='' WHERE id_servico='46';
--14/06/2011 14:28:32
UPDATE vsites_servico_campo SET campo='certidao_nome',tipo='text',nome='NOME',valor='',largura='470',mascara='',site='1',ordenacao='1',obrigatorio='0'
						WHERE id_servico_campo='738';
--14/06/2011 14:28:32
UPDATE vsites_servico_campo SET campo='certidao_estado',tipo='text',nome='ESTADO',valor='',largura='470',mascara='',site='1',ordenacao='2',obrigatorio='0'
						WHERE id_servico_campo='482';
--14/06/2011 14:28:32
UPDATE vsites_servico_campo SET campo='certidao_cidade',tipo='text',nome='CIDADE',valor='',largura='470',mascara='',site='1',ordenacao='3',obrigatorio='0'
						WHERE id_servico_campo='116';
--14/06/2011 14:28:32
UPDATE vsites_servico_campo SET campo='certidao_cartorio',tipo='text',nome='CARTORIO',valor='',largura='470',mascara='',site='1',ordenacao='4',obrigatorio='0'
						WHERE id_servico_campo='30';
--14/06/2011 14:28:32
UPDATE vsites_servico_campo SET campo='certidao_data_nascimento',tipo='text',nome='DATA DE NASCIMENTO',valor='',largura='470',mascara='',site='1',ordenacao='5',obrigatorio='0'
						WHERE id_servico_campo='386';
--14/06/2011 14:28:33
UPDATE vsites_servico_campo SET campo='certidao_protocolo',tipo='text',nome='PROTOCOLO',valor='',largura='470',mascara='',site='0',ordenacao='6',obrigatorio='0'
						WHERE id_servico_campo='967';
--14/06/2011 14:28:33
UPDATE vsites_servico_campo SET campo='certidao_rg',tipo='text',nome='RG',valor='',largura='470',mascara='',site='1',ordenacao='7',obrigatorio='0'
						WHERE id_servico_campo='1141';
--14/06/2011 14:28:33
UPDATE vsites_servico_campo SET campo='certidao_cpf',tipo='text',nome='CPF',valor='',largura='470',mascara='',site='1',ordenacao='8',obrigatorio='0'
						WHERE id_servico_campo='290';
--14/06/2011 14:28:33
UPDATE vsites_servico_campo SET campo='certidao_conjuge',tipo='text',nome='CONJUGE',valor='',largura='470',mascara='',site='1',ordenacao='9',obrigatorio='0'
						WHERE id_servico_campo='275';
--14/06/2011 14:28:33
UPDATE vsites_servico_campo SET campo='certidao_matriculas_encontradas',tipo='text',nome='MATRICULAS ENCONTRADAS',valor='',largura='470',mascara='',site='0',ordenacao='10',obrigatorio='0'
						WHERE id_servico_campo='673';
--14/06/2011 14:28:33
UPDATE vsites_servico_campo SET campo='certidao_cnpj',tipo='text',nome='CNPJ',valor='',largura='470',mascara='',site='0',ordenacao='11',obrigatorio='0'
						WHERE id_servico_campo='1244';
--14/06/2011 14:28:33
DELETE FROM vsites_servico_campo WHERE id_servico_campo = '' AND id_servico='46';
--14/06/2011 14:28:56
UPDATE vsites_servico SET dias='', status='Ativo', descricao='Rodobens', site='1',desc_site='',servico_desc='',site_menu='' WHERE id_servico='46';
--14/06/2011 14:28:56
UPDATE vsites_servico_campo SET campo='certidao_nome',tipo='text',nome='NOME',valor='',largura='470',mascara='',site='1',ordenacao='1',obrigatorio='0'
						WHERE id_servico_campo='738';
--14/06/2011 14:28:56
UPDATE vsites_servico_campo SET campo='certidao_estado',tipo='text',nome='ESTADO',valor='',largura='470',mascara='',site='1',ordenacao='2',obrigatorio='0'
						WHERE id_servico_campo='482';
--14/06/2011 14:28:56
UPDATE vsites_servico_campo SET campo='certidao_cidade',tipo='text',nome='CIDADE',valor='',largura='470',mascara='',site='1',ordenacao='3',obrigatorio='0'
						WHERE id_servico_campo='116';
--14/06/2011 14:28:56
UPDATE vsites_servico_campo SET campo='certidao_cartorio',tipo='text',nome='CARTORIO',valor='',largura='470',mascara='',site='1',ordenacao='4',obrigatorio='0'
						WHERE id_servico_campo='30';
--14/06/2011 14:28:56
UPDATE vsites_servico_campo SET campo='certidao_data_nascimento',tipo='text',nome='DATA DE NASCIMENTO',valor='',largura='470',mascara='',site='1',ordenacao='5',obrigatorio='0'
						WHERE id_servico_campo='386';
--14/06/2011 14:28:56
UPDATE vsites_servico_campo SET campo='certidao_protocolo',tipo='text',nome='PROTOCOLO',valor='',largura='470',mascara='',site='0',ordenacao='6',obrigatorio='0'
						WHERE id_servico_campo='967';
--14/06/2011 14:28:56
UPDATE vsites_servico_campo SET campo='certidao_rg',tipo='text',nome='RG',valor='',largura='470',mascara='',site='1',ordenacao='7',obrigatorio='0'
						WHERE id_servico_campo='1141';
--14/06/2011 14:28:56
UPDATE vsites_servico_campo SET campo='certidao_cpf',tipo='text',nome='CPF',valor='',largura='470',mascara='',site='1',ordenacao='8',obrigatorio='0'
						WHERE id_servico_campo='290';
--14/06/2011 14:28:56
UPDATE vsites_servico_campo SET campo='certidao_conjuge',tipo='text',nome='CONJUGE',valor='',largura='470',mascara='',site='1',ordenacao='9',obrigatorio='0'
						WHERE id_servico_campo='275';
--14/06/2011 14:28:56
UPDATE vsites_servico_campo SET campo='certidao_matriculas_encontradas',tipo='text',nome='MATRICULAS ENCONTRADAS',valor='',largura='470',mascara='',site='0',ordenacao='10',obrigatorio='0'
						WHERE id_servico_campo='673';
--14/06/2011 14:28:56
UPDATE vsites_servico_campo SET campo='certidao_cnpj',tipo='text',nome='CNPJ',valor='',largura='470',mascara='',site='0',ordenacao='11',obrigatorio='0'
						WHERE id_servico_campo='1244';
--14/06/2011 14:28:56
DELETE FROM vsites_servico_campo WHERE id_servico_campo = '' AND id_servico='46';
--14/06/2011 14:32:34
UPDATE vsites_servico SET dias='', status='Ativo', descricao='certidão', site='1',desc_site='',servico_desc='',site_menu='' WHERE id_servico='46';
--14/06/2011 14:32:34
UPDATE vsites_servico_campo SET campo='certidao_nome',tipo='text',nome='NOME',valor='',largura='470',mascara='',site='1',ordenacao='1',obrigatorio='0'
						WHERE id_servico_campo='738';
--14/06/2011 14:32:34
UPDATE vsites_servico_campo SET campo='certidao_estado',tipo='text',nome='ESTADO',valor='',largura='470',mascara='',site='1',ordenacao='2',obrigatorio='0'
						WHERE id_servico_campo='482';
--14/06/2011 14:32:34
UPDATE vsites_servico_campo SET campo='certidao_cidade',tipo='text',nome='CIDADE',valor='',largura='470',mascara='',site='1',ordenacao='3',obrigatorio='0'
						WHERE id_servico_campo='116';
--14/06/2011 14:32:34
UPDATE vsites_servico_campo SET campo='certidao_cartorio',tipo='text',nome='CARTORIO',valor='',largura='470',mascara='',site='1',ordenacao='4',obrigatorio='0'
						WHERE id_servico_campo='30';
--14/06/2011 14:32:34
UPDATE vsites_servico_campo SET campo='certidao_data_nascimento',tipo='text',nome='DATA DE NASCIMENTO',valor='',largura='470',mascara='',site='1',ordenacao='5',obrigatorio='0'
						WHERE id_servico_campo='386';
--14/06/2011 14:32:34
UPDATE vsites_servico_campo SET campo='certidao_protocolo',tipo='text',nome='PROTOCOLO',valor='',largura='470',mascara='',site='0',ordenacao='6',obrigatorio='0'
						WHERE id_servico_campo='967';
--14/06/2011 14:32:34
UPDATE vsites_servico_campo SET campo='certidao_rg',tipo='text',nome='RG',valor='',largura='470',mascara='',site='1',ordenacao='7',obrigatorio='0'
						WHERE id_servico_campo='1141';
--14/06/2011 14:32:34
UPDATE vsites_servico_campo SET campo='certidao_cpf',tipo='text',nome='CPF',valor='',largura='470',mascara='',site='1',ordenacao='8',obrigatorio='0'
						WHERE id_servico_campo='290';
--14/06/2011 14:32:34
UPDATE vsites_servico_campo SET campo='certidao_conjuge',tipo='text',nome='CONJUGE',valor='',largura='470',mascara='',site='1',ordenacao='9',obrigatorio='0'
						WHERE id_servico_campo='275';
--14/06/2011 14:32:34
UPDATE vsites_servico_campo SET campo='certidao_matriculas_encontradas',tipo='text',nome='MATRICULAS ENCONTRADAS',valor='',largura='470',mascara='',site='0',ordenacao='10',obrigatorio='0'
						WHERE id_servico_campo='673';
--14/06/2011 14:32:34
UPDATE vsites_servico_campo SET campo='certidao_cnpj',tipo='text',nome='CNPJ',valor='',largura='470',mascara='',site='0',ordenacao='11',obrigatorio='0'
						WHERE id_servico_campo='1244';
--14/06/2011 14:32:34
DELETE FROM vsites_servico_campo WHERE id_servico_campo = '' AND id_servico='46';
--14/06/2011 14:32:54
UPDATE vsites_servico SET dias='', status='Inativo', descricao='certidão', site='1',desc_site='',servico_desc='',site_menu='' WHERE id_servico='46';
--14/06/2011 14:32:54
UPDATE vsites_servico_campo SET campo='certidao_nome',tipo='text',nome='NOME',valor='',largura='470',mascara='',site='1',ordenacao='1',obrigatorio='0'
						WHERE id_servico_campo='738';
--14/06/2011 14:32:54
UPDATE vsites_servico_campo SET campo='certidao_estado',tipo='text',nome='ESTADO',valor='',largura='470',mascara='',site='1',ordenacao='2',obrigatorio='0'
						WHERE id_servico_campo='482';
--14/06/2011 14:32:54
UPDATE vsites_servico_campo SET campo='certidao_cidade',tipo='text',nome='CIDADE',valor='',largura='470',mascara='',site='1',ordenacao='3',obrigatorio='0'
						WHERE id_servico_campo='116';
--14/06/2011 14:32:54
UPDATE vsites_servico_campo SET campo='certidao_cartorio',tipo='text',nome='CARTORIO',valor='',largura='470',mascara='',site='1',ordenacao='4',obrigatorio='0'
						WHERE id_servico_campo='30';
--14/06/2011 14:32:54
UPDATE vsites_servico_campo SET campo='certidao_data_nascimento',tipo='text',nome='DATA DE NASCIMENTO',valor='',largura='470',mascara='',site='1',ordenacao='5',obrigatorio='0'
						WHERE id_servico_campo='386';
--14/06/2011 14:32:54
UPDATE vsites_servico_campo SET campo='certidao_protocolo',tipo='text',nome='PROTOCOLO',valor='',largura='470',mascara='',site='0',ordenacao='6',obrigatorio='0'
						WHERE id_servico_campo='967';
--14/06/2011 14:32:54
UPDATE vsites_servico_campo SET campo='certidao_rg',tipo='text',nome='RG',valor='',largura='470',mascara='',site='1',ordenacao='7',obrigatorio='0'
						WHERE id_servico_campo='1141';
--14/06/2011 14:32:54
UPDATE vsites_servico_campo SET campo='certidao_cpf',tipo='text',nome='CPF',valor='',largura='470',mascara='',site='1',ordenacao='8',obrigatorio='0'
						WHERE id_servico_campo='290';
--14/06/2011 14:32:54
UPDATE vsites_servico_campo SET campo='certidao_conjuge',tipo='text',nome='CONJUGE',valor='',largura='470',mascara='',site='1',ordenacao='9',obrigatorio='0'
						WHERE id_servico_campo='275';
--14/06/2011 14:32:54
UPDATE vsites_servico_campo SET campo='certidao_matriculas_encontradas',tipo='text',nome='MATRICULAS ENCONTRADAS',valor='',largura='470',mascara='',site='0',ordenacao='10',obrigatorio='0'
						WHERE id_servico_campo='673';
--14/06/2011 14:32:54
UPDATE vsites_servico_campo SET campo='certidao_cnpj',tipo='text',nome='CNPJ',valor='',largura='470',mascara='',site='0',ordenacao='11',obrigatorio='0'
						WHERE id_servico_campo='1244';
--14/06/2011 14:32:54
DELETE FROM vsites_servico_campo WHERE id_servico_campo = '' AND id_servico='46';
--14/06/2011 14:33:31
INSERT INTO vsites_servico (id_departamento, status, site, descricao, desc_site, servico_desc, site_menu) VALUES ('4','Ativo','1','Rodobens','Rodobens','','1');
--14/06/2011 14:34:01
UPDATE vsites_servico SET dias='', status='Ativo', descricao='Rodobens', site='1',desc_site='Rodobens',servico_desc='',site_menu='1' WHERE id_servico='197';
--14/06/2011 14:34:01
INSERT INTO vsites_servico_campo (id_servico, campo, nome, tipo, largura, site, ordenacao) VALUES ('197','certidao_cidade','','text','470','0','1');
--14/06/2011 14:34:01
DELETE FROM vsites_servico_campo WHERE id_servico_campo = '' AND id_servico='197';
--14/06/2011 14:34:24
UPDATE vsites_servico SET dias='', status='Ativo', descricao='Rodobens', site='1',desc_site='Rodobens',servico_desc='',site_menu='1' WHERE id_servico='197';
--14/06/2011 14:34:24
UPDATE vsites_servico_campo SET campo='certidao_cidade',tipo='text',nome='',valor='',largura='470',mascara='',site='0',ordenacao='1',obrigatorio='0'
						WHERE id_servico_campo='1705';
--14/06/2011 14:34:24
INSERT INTO vsites_servico_campo (id_servico, campo, nome, tipo, largura, site, ordenacao) VALUES ('197','certidao_cnpj','','text','470','0','2');
--14/06/2011 14:34:24
DELETE FROM vsites_servico_campo WHERE id_servico_campo = '' AND id_servico='197';
--14/06/2011 14:35:06
UPDATE vsites_servico SET dias='', status='Ativo', descricao='Rodobens', site='1',desc_site='Rodobens',servico_desc='',site_menu='1' WHERE id_servico='197';
--14/06/2011 14:35:06
UPDATE vsites_servico_campo SET campo='certidao_cidade',tipo='text',nome='CIDADE',valor='',largura='470',mascara='',site='0',ordenacao='1',obrigatorio='0'
						WHERE id_servico_campo='1705';
--14/06/2011 14:35:06
UPDATE vsites_servico_campo SET campo='certidao_cnpj',tipo='text',nome='CNPJ',valor='',largura='470',mascara='',site='0',ordenacao='2',obrigatorio='0'
						WHERE id_servico_campo='1706';
--14/06/2011 14:35:06
INSERT INTO vsites_servico_campo (id_servico, campo, nome, tipo, largura, site, ordenacao) VALUES ('197','certidao_cpf','CPF','text','470','0','3');
--14/06/2011 14:35:06
DELETE FROM vsites_servico_campo WHERE id_servico_campo = '' AND id_servico='197';
--14/06/2011 14:36:24
UPDATE vsites_servico SET dias='', status='Ativo', descricao='Rodobens', site='1',desc_site='Rodobens',servico_desc='',site_menu='1' WHERE id_servico='197';
--14/06/2011 14:36:24
UPDATE vsites_servico_campo SET campo='certidao_cidade',tipo='text',nome='CIDADE',valor='',largura='470',mascara='',site='0',ordenacao='1',obrigatorio='0'
						WHERE id_servico_campo='1705';
--14/06/2011 14:36:24
UPDATE vsites_servico_campo SET campo='certidao_cnpj',tipo='text',nome='CNPJ',valor='',largura='470',mascara='',site='0',ordenacao='2',obrigatorio='0'
						WHERE id_servico_campo='1706';
--14/06/2011 14:36:24
UPDATE vsites_servico_campo SET campo='certidao_cpf',tipo='text',nome='CPF',valor='',largura='470',mascara='',site='0',ordenacao='3',obrigatorio='0'
						WHERE id_servico_campo='1707';
--14/06/2011 14:36:24
INSERT INTO vsites_servico_campo (id_servico, campo, nome, tipo, largura, site, ordenacao) VALUES ('197','certidao_numero','NUMERO','text','470','0','4');
--14/06/2011 14:36:24
INSERT INTO vsites_servico_campo (id_servico, campo, nome, tipo, largura, site, ordenacao) VALUES ('197','certidao_nome','NOME','text','470','0','5');
--14/06/2011 14:36:24
INSERT INTO vsites_servico_campo (id_servico, campo, nome, tipo, largura, site, ordenacao) VALUES ('197','id_fatura','','text','470','0','6');
--14/06/2011 14:36:24
DELETE FROM vsites_servico_campo WHERE id_servico_campo = '' AND id_servico='197';
--14/06/2011 14:42:03
UPDATE vsites_servico SET dias='', status='Inativo', descricao='Rodobens', site='1',desc_site='Rodobens',servico_desc='',site_menu='1' WHERE id_servico='197';
--14/06/2011 14:42:03
UPDATE vsites_servico_campo SET campo='certidao_cidade',tipo='text',nome='CIDADE',valor='',largura='470',mascara='',site='0',ordenacao='1',obrigatorio='0'
						WHERE id_servico_campo='1705';
--14/06/2011 14:42:03
UPDATE vsites_servico_campo SET campo='certidao_cnpj',tipo='text',nome='CNPJ',valor='',largura='470',mascara='',site='0',ordenacao='2',obrigatorio='0'
						WHERE id_servico_campo='1706';
--14/06/2011 14:42:03
UPDATE vsites_servico_campo SET campo='certidao_cpf',tipo='text',nome='CPF',valor='',largura='470',mascara='',site='0',ordenacao='3',obrigatorio='0'
						WHERE id_servico_campo='1707';
--14/06/2011 14:42:03
UPDATE vsites_servico_campo SET campo='certidao_numero',tipo='text',nome='NUMERO',valor='',largura='470',mascara='',site='0',ordenacao='4',obrigatorio='0'
						WHERE id_servico_campo='1708';
--14/06/2011 14:42:03
UPDATE vsites_servico_campo SET campo='certidao_nome',tipo='text',nome='NOME',valor='',largura='470',mascara='',site='0',ordenacao='5',obrigatorio='0'
						WHERE id_servico_campo='1709';
--14/06/2011 14:42:03
UPDATE vsites_servico_campo SET campo='id_fatura',tipo='text',nome='',valor='',largura='470',mascara='',site='0',ordenacao='6',obrigatorio='0'
						WHERE id_servico_campo='1710';
--14/06/2011 14:42:03
DELETE FROM vsites_servico_campo WHERE id_servico_campo = '' AND id_servico='197';
--14/06/2011 14:46:27
INSERT INTO vsites_servico (id_departamento, status, site, descricao, desc_site, servico_desc, site_menu) VALUES ('4','Ativo','1','Consórcio Rodobens','Consórcio Rodobens','','1');
--14/06/2011 14:46:27
INSERT INTO vsites_servico_campo (id_servico, campo, nome, tipo, largura, site, ordenacao) VALUES ('198','certidao_nome','NOME','text','470','1','1');
--14/06/2011 14:47:10
UPDATE vsites_servico SET dias='', status='Ativo', descricao='Consórcio Rodobens', site='1',desc_site='Consórcio Rodobens',servico_desc='',site_menu='1' WHERE id_servico='198';
--14/06/2011 14:47:10
UPDATE vsites_servico_campo SET campo='certidao_nome',tipo='text',nome='NOME',valor='',largura='470',mascara='',site='1',ordenacao='1',obrigatorio='0'
						WHERE id_servico_campo='1711';
--14/06/2011 14:47:10
INSERT INTO vsites_servico_campo (id_servico, campo, nome, tipo, largura, site, ordenacao) VALUES ('198','certidao_cpf','CPF','text','470','1','2');
--14/06/2011 14:47:10
INSERT INTO vsites_servico_campo (id_servico, campo, nome, tipo, largura, site, ordenacao) VALUES ('198','certidao_cnpj','CNPJ','text','470','1','3');
--14/06/2011 14:47:10
DELETE FROM vsites_servico_campo WHERE id_servico_campo = '' AND id_servico='198';
--14/06/2011 14:48:36
UPDATE vsites_servico SET dias='', status='Ativo', descricao='Consórcio Rodobens', site='1',desc_site='Consórcio Rodobens',servico_desc='',site_menu='1' WHERE id_servico='198';
--14/06/2011 14:48:36
UPDATE vsites_servico_campo SET campo='certidao_nome',tipo='text',nome='NOME',valor='',largura='470',mascara='',site='1',ordenacao='1',obrigatorio='0'
						WHERE id_servico_campo='1711';
--14/06/2011 14:48:36
UPDATE vsites_servico_campo SET campo='certidao_cpf',tipo='text',nome='CPF',valor='',largura='470',mascara='',site='1',ordenacao='2',obrigatorio='0'
						WHERE id_servico_campo='1712';
--14/06/2011 14:48:36
UPDATE vsites_servico_campo SET campo='certidao_cnpj',tipo='text',nome='CNPJ',valor='',largura='470',mascara='',site='1',ordenacao='3',obrigatorio='0'
						WHERE id_servico_campo='1713';
--14/06/2011 14:48:36
INSERT INTO vsites_servico_campo (id_servico, campo, nome, tipo, largura, site, ordenacao) VALUES ('198','certidao_estado','ESTADO','text','470','1','4');
--14/06/2011 14:48:36
INSERT INTO vsites_servico_campo (id_servico, campo, nome, tipo, largura, site, ordenacao) VALUES ('198','certidao_cidade','CIDADE','text','470','1','5');
--14/06/2011 14:48:36
INSERT INTO vsites_servico_campo (id_servico, campo, nome, tipo, largura, site, ordenacao) VALUES ('198','certidao_numero','NUMERO','text','470','1','6');
--14/06/2011 14:48:36
INSERT INTO vsites_servico_campo (id_servico, campo, nome, tipo, largura, site, ordenacao) VALUES ('198','certidao_endereco_imovel','ENDEREÇO DO IMOVEL','text','470','1','7');
--14/06/2011 14:48:36
DELETE FROM vsites_servico_campo WHERE id_servico_campo = '' AND id_servico='198';
--14/06/2011 14:49:09
UPDATE vsites_servico SET dias='', status='Ativo', descricao='Consórcio Rodobens', site='1',desc_site='Consórcio Rodobens',servico_desc='',site_menu='' WHERE id_servico='198';
--14/06/2011 14:49:09
UPDATE vsites_servico_campo SET campo='certidao_nome',tipo='text',nome='NOME',valor='',largura='470',mascara='',site='1',ordenacao='1',obrigatorio='0'
						WHERE id_servico_campo='1711';
--14/06/2011 14:49:09
UPDATE vsites_servico_campo SET campo='certidao_cpf',tipo='text',nome='CPF',valor='',largura='470',mascara='',site='1',ordenacao='2',obrigatorio='0'
						WHERE id_servico_campo='1712';
--14/06/2011 14:49:09
UPDATE vsites_servico_campo SET campo='certidao_cnpj',tipo='text',nome='CNPJ',valor='',largura='470',mascara='',site='1',ordenacao='3',obrigatorio='0'
						WHERE id_servico_campo='1713';
--14/06/2011 14:49:09
UPDATE vsites_servico_campo SET campo='certidao_estado',tipo='text',nome='ESTADO',valor='',largura='470',mascara='',site='1',ordenacao='4',obrigatorio='0'
						WHERE id_servico_campo='1714';
--14/06/2011 14:49:09
UPDATE vsites_servico_campo SET campo='certidao_cidade',tipo='text',nome='CIDADE',valor='',largura='470',mascara='',site='1',ordenacao='5',obrigatorio='0'
						WHERE id_servico_campo='1715';
--14/06/2011 14:49:09
UPDATE vsites_servico_campo SET campo='certidao_numero',tipo='text',nome='NUMERO',valor='',largura='470',mascara='',site='1',ordenacao='6',obrigatorio='0'
						WHERE id_servico_campo='1716';
--14/06/2011 14:49:09
UPDATE vsites_servico_campo SET campo='certidao_endereco_imovel',tipo='text',nome='ENDEREÇO DO IMOVEL',valor='',largura='470',mascara='',site='1',ordenacao='7',obrigatorio='0'
						WHERE id_servico_campo='1717';
--14/06/2011 14:49:09
DELETE FROM vsites_servico_campo WHERE id_servico_campo = '' AND id_servico='198';
--05/07/2011 20:36:32
UPDATE vsites_servico SET dias='', status='Ativo', descricao='Certidão de Pacto Antenupcial (2ª via)', site='1',desc_site='Certidão de Pacto Antenupcial (2ª via)',servico_desc='<P>
Certidão de pacto Antenupcial é o contrato solene, realizado antes do casamento, por meio do qual as partes dispõem sobre o regime de bens que vigorará entre elas durante o matrimônio.
</P>',site_menu='1' WHERE id_servico='106';
--05/07/2011 20:36:32
UPDATE vsites_servico_campo SET campo='certidao_finalidade',tipo='text',nome='FINALIDADE DO DOCUMENTO',valor='',largura='470',mascara='',site='1',ordenacao='1',obrigatorio='1'
						WHERE id_servico_campo='587';
--05/07/2011 20:36:32
UPDATE vsites_servico_campo SET campo='certidao_rg',tipo='text',nome='RG',valor='',largura='470',mascara='',site='1',ordenacao='2',obrigatorio='0'
						WHERE id_servico_campo='1187';
--05/07/2011 20:36:32
UPDATE vsites_servico_campo SET campo='certidao_estado',tipo='text',nome='ESTADO',valor='',largura='470',mascara='',site='1',ordenacao='3',obrigatorio='1'
						WHERE id_servico_campo='535';
--05/07/2011 20:36:32
UPDATE vsites_servico_campo SET campo='certidao_cidade',tipo='text',nome='CIDADE',valor='',largura='470',mascara='',site='1',ordenacao='4',obrigatorio='1'
						WHERE id_servico_campo='171';
--05/07/2011 20:36:32
UPDATE vsites_servico_campo SET campo='certidao_mae',tipo='text',nome='MAE',valor='',largura='470',mascara='',site='1',ordenacao='5',obrigatorio='1'
						WHERE id_servico_campo='658';
--05/07/2011 20:36:32
UPDATE vsites_servico_campo SET campo='certidao_pai',tipo='text',nome='PAI',valor='',largura='470',mascara='',site='1',ordenacao='6',obrigatorio='0'
						WHERE id_servico_campo='924';
--05/07/2011 20:36:32
UPDATE vsites_servico_campo SET campo='certidao_esposa',tipo='text',nome='ESPOSA/ESPOSO',valor='',largura='470',mascara='',site='1',ordenacao='7',obrigatorio='0'
						WHERE id_servico_campo='466';
--05/07/2011 20:36:32
UPDATE vsites_servico_campo SET campo='certidao_data_casamento',tipo='text',nome='DATA DE CASAMENTO',valor='',largura='470',mascara='',site='1',ordenacao='8',obrigatorio='0'
						WHERE id_servico_campo='366';
--05/07/2011 20:36:32
UPDATE vsites_servico_campo SET campo='certidao_cartorio',tipo='text',nome='CARTORIO',valor='',largura='470',mascara='',site='1',ordenacao='9',obrigatorio='1'
						WHERE id_servico_campo='60';
--05/07/2011 20:36:32
UPDATE vsites_servico_campo SET campo='certidao_livro',tipo='text',nome='LIVRO',valor='',largura='470',mascara='',site='1',ordenacao='10',obrigatorio='1'
						WHERE id_servico_campo='630';
--05/07/2011 20:36:32
UPDATE vsites_servico_campo SET campo='certidao_folha',tipo='text',nome='FOLHA',valor='',largura='470',mascara='',site='1',ordenacao='11',obrigatorio='1'
						WHERE id_servico_campo='608';
--05/07/2011 20:36:32
DELETE FROM vsites_servico_campo WHERE id_servico_campo = '' AND id_servico='106';
--05/07/2011 20:37:05
UPDATE vsites_servico SET dias='', status='Ativo', descricao='Certidão de Negativa do IPTU (Tributos Imobiliários)', site='1',desc_site='Certidão de Negativa do IPTU',servico_desc='<p>
Certidão solicitada par verificar se tem débitos no imóvel, ou seja, impostos.
</p>',site_menu='1' WHERE id_servico='34';
--05/07/2011 20:37:05
UPDATE vsites_servico_campo SET campo='certidao_nome',tipo='text',nome='NOME',valor='',largura='470',mascara='',site='1',ordenacao='1',obrigatorio='1'
						WHERE id_servico_campo='788';
--05/07/2011 20:37:05
UPDATE vsites_servico_campo SET campo='certidao_estado',tipo='text',nome='ESTADO',valor='',largura='470',mascara='',site='1',ordenacao='2',obrigatorio='1'
						WHERE id_servico_campo='530';
--05/07/2011 20:37:05
UPDATE vsites_servico_campo SET campo='certidao_cidade',tipo='text',nome='CIDADE',valor='',largura='470',mascara='',site='1',ordenacao='3',obrigatorio='1'
						WHERE id_servico_campo='166';
--05/07/2011 20:37:05
UPDATE vsites_servico_campo SET campo='certidao_numero_contribuinte',tipo='text',nome='NUMERO DE CONTRIBUINTE',valor='',largura='470',mascara='',site='1',ordenacao='4',obrigatorio='1'
						WHERE id_servico_campo='840';
--05/07/2011 20:37:05
DELETE FROM vsites_servico_campo WHERE id_servico_campo = '' AND id_servico='34';
--05/07/2011 20:37:34
UPDATE vsites_servico SET dias='', status='Ativo', descricao='Objeto e Pé', site='1',desc_site='Certidão de Objeto e Pé',servico_desc='<p>
Certidão que consta um breve resumo do processo, ou seja, natureza da ação, partes, principais atos praticados e a situação atual do processo.  
</P>',site_menu='1' WHERE id_servico='19';
--05/07/2011 20:37:34
UPDATE vsites_servico_campo SET campo='certidao_nome',tipo='text',nome='NOME',valor='',largura='470',mascara='',site='1',ordenacao='1',obrigatorio='0'
						WHERE id_servico_campo='1545';
--05/07/2011 20:37:34
UPDATE vsites_servico_campo SET campo='certidao_rg',tipo='text',nome='RG',valor='',largura='470',mascara='',site='1',ordenacao='2',obrigatorio='0'
						WHERE id_servico_campo='1208';
--05/07/2011 20:37:34
UPDATE vsites_servico_campo SET campo='certidao_cpf',tipo='text',nome='CPF',valor='',largura='470',mascara='',site='1',ordenacao='3',obrigatorio='0'
						WHERE id_servico_campo='356';
--05/07/2011 20:37:34
UPDATE vsites_servico_campo SET campo='certidao_cnpj',tipo='text',nome='CNPJ',valor='',largura='470',mascara='',site='1',ordenacao='4',obrigatorio='0'
						WHERE id_servico_campo='269';
--05/07/2011 20:37:34
UPDATE vsites_servico_campo SET campo='certidao_estado',tipo='text',nome='ESTADO',valor='',largura='470',mascara='',site='1',ordenacao='5',obrigatorio='1'
						WHERE id_servico_campo='534';
--05/07/2011 20:37:34
UPDATE vsites_servico_campo SET campo='certidao_cidade',tipo='text',nome='CIDADE',valor='',largura='470',mascara='',site='1',ordenacao='6',obrigatorio='1'
						WHERE id_servico_campo='170';
--05/07/2011 20:37:34
UPDATE vsites_servico_campo SET campo='certidao_requerido',tipo='text',nome='NOME DO REQUERIDO',valor='',largura='470',mascara='',site='1',ordenacao='7',obrigatorio='1'
						WHERE id_servico_campo='1058';
--05/07/2011 20:37:34
UPDATE vsites_servico_campo SET campo='certidao_requerente',tipo='text',nome='NOME DO REQUERENTE',valor='',largura='470',mascara='',site='1',ordenacao='8',obrigatorio='1'
						WHERE id_servico_campo='1056';
--05/07/2011 20:37:34
UPDATE vsites_servico_campo SET campo='certidao_tipo_processo',tipo='text',nome='TIPO DE PROCESSO',valor='',largura='470',mascara='',site='1',ordenacao='9',obrigatorio='1'
						WHERE id_servico_campo='1231';
--05/07/2011 20:37:34
UPDATE vsites_servico_campo SET campo='certidao_n_processo',tipo='text',nome='NUMERO DO PROCESSO',valor='',largura='470',mascara='',site='1',ordenacao='10',obrigatorio='1'
						WHERE id_servico_campo='854';
--05/07/2011 20:37:34
UPDATE vsites_servico_campo SET campo='certidao_data',tipo='text',nome='DATA PROCESSO',valor='',largura='470',mascara='',site='1',ordenacao='11',obrigatorio='1'
						WHERE id_servico_campo='361';
--05/07/2011 20:37:34
UPDATE vsites_servico_campo SET campo=?,tipo='certidao_comarca_forum',nome='COMARCA 'text' FORUM',valor='',largura='470',mascara='',site='1',ordenacao='12',obrigatorio='1'
						WHERE id_servico_campo='271';
--05/07/2011 20:37:34
UPDATE vsites_servico_campo SET campo='certidao_protocolo',tipo='text',nome='PROTOCOLO',valor='',largura='470',mascara='',site='0',ordenacao='13',obrigatorio='0'
						WHERE id_servico_campo='1008';
--05/07/2011 20:37:34
UPDATE vsites_servico_campo SET campo='certidao_vara',tipo='text',nome='VARA',valor='',largura='470',mascara='',site='1',ordenacao='14',obrigatorio='1'
						WHERE id_servico_campo='1243';
--05/07/2011 20:37:34
DELETE FROM vsites_servico_campo WHERE id_servico_campo = '' AND id_servico='19';
--05/07/2011 20:38:03
UPDATE vsites_servico SET dias='', status='Ativo', descricao='Justiça Federal', site='1',desc_site='Certidão da Justiça Federal',servico_desc='<P>
Cumpre a mesma finalidade da certidão extraída no distribuidor cível porém abrange as ações na esfera federal.
Documentos necessários para dar entrada na solicitação; 
Pessoa Física: Nome completo, CPF, RG, Cidade, Estado.
Pessoa Jurídica: Nome completo, CNPJ, Cidade, Estado.
</p>',site_menu='1' WHERE id_servico='8';
--05/07/2011 20:38:03
UPDATE vsites_servico_campo SET campo='certidao_nome',tipo='text',nome='NOME',valor='',largura='470',mascara='',site='1',ordenacao='1',obrigatorio='1'
						WHERE id_servico_campo='778';
--05/07/2011 20:38:03
UPDATE vsites_servico_campo SET campo='certidao_rg',tipo='text',nome='RG',valor='',largura='470',mascara='',site='1',ordenacao='2',obrigatorio='0'
						WHERE id_servico_campo='1175';
--05/07/2011 20:38:03
UPDATE vsites_servico_campo SET campo='certidao_cpf',tipo='text',nome='CPF',valor='',largura='470',mascara='',site='1',ordenacao='3',obrigatorio='0'
						WHERE id_servico_campo='323';
--05/07/2011 20:38:03
UPDATE vsites_servico_campo SET campo='certidao_cnpj',tipo='text',nome='CNPJ',valor='',largura='470',mascara='',site='1',ordenacao='4',obrigatorio='0'
						WHERE id_servico_campo='237';
--05/07/2011 20:38:03
UPDATE vsites_servico_campo SET campo='certidao_estado',tipo='text',nome='ESTADO',valor='',largura='470',mascara='',site='1',ordenacao='5',obrigatorio='1'
						WHERE id_servico_campo='518';
--05/07/2011 20:38:03
UPDATE vsites_servico_campo SET campo='certidao_cidade',tipo='text',nome='CIDADE',valor='',largura='470',mascara='',site='1',ordenacao='6',obrigatorio='1'
						WHERE id_servico_campo='154';
--05/07/2011 20:38:03
DELETE FROM vsites_servico_campo WHERE id_servico_campo = '' AND id_servico='8';
--05/07/2011 20:38:49
UPDATE vsites_servico SET dias='', status='Ativo', descricao='Averbação - Divórcio', site='1',desc_site='Certidão de Averbação de Divórcio',servico_desc='<P>
Sentença do juiz, esta certidão poderá estar em três vias ou em uma, o mesmo tem que ser original onde é entregue a uma das partes, no ato da assinatura do divórcio ou separação.
</P>',site_menu='1' WHERE id_servico='29';
--05/07/2011 20:38:49
UPDATE vsites_servico_campo SET campo='certidao_nome',tipo='text',nome='NOME',valor='',largura='470',mascara='',site='1',ordenacao='1',obrigatorio='1'
						WHERE id_servico_campo='730';
--05/07/2011 20:38:49
UPDATE vsites_servico_campo SET campo='certidao_conjuge',tipo='text',nome='CONJUGE',valor='',largura='470',mascara='',site='1',ordenacao='2',obrigatorio='1'
						WHERE id_servico_campo='273';
--05/07/2011 20:38:49
UPDATE vsites_servico_campo SET campo='certidao_data_casamento',tipo='text',nome='DATA DE CASAMENTO',valor='',largura='470',mascara='',site='1',ordenacao='3',obrigatorio='1'
						WHERE id_servico_campo='362';
--05/07/2011 20:38:49
UPDATE vsites_servico_campo SET campo='certidao_livro',tipo='text',nome='LIVRO',valor='',largura='470',mascara='',site='1',ordenacao='4',obrigatorio='0'
						WHERE id_servico_campo='617';
--05/07/2011 20:38:49
UPDATE vsites_servico_campo SET campo='certidao_folha',tipo='text',nome='FOLHA',valor='',largura='470',mascara='',site='1',ordenacao='5',obrigatorio='0'
						WHERE id_servico_campo='594';
--05/07/2011 20:38:49
UPDATE vsites_servico_campo SET campo='certidao_registro',tipo='text',nome='REGISTRO',valor='',largura='470',mascara='',site='1',ordenacao='6',obrigatorio='0'
						WHERE id_servico_campo='1042';
--05/07/2011 20:38:49
UPDATE vsites_servico_campo SET campo='certidao_estado',tipo='text',nome='ESTADO',valor='',largura='470',mascara='',site='1',ordenacao='7',obrigatorio='1'
						WHERE id_servico_campo='473';
--05/07/2011 20:38:49
UPDATE vsites_servico_campo SET campo='certidao_cidade',tipo='text',nome='CIDADE',valor='',largura='470',mascara='',site='1',ordenacao='8',obrigatorio='1'
						WHERE id_servico_campo='107';
--05/07/2011 20:38:49
UPDATE vsites_servico_campo SET campo='certidao_cartorio',tipo='text',nome='CARTORIO',valor='',largura='470',mascara='',site='1',ordenacao='9',obrigatorio='0'
						WHERE id_servico_campo='26';
--05/07/2011 20:38:49
UPDATE vsites_servico_campo SET campo='certidao_averbacao',tipo='text',nome='AVERBACAO',valor='',largura='470',mascara='',site='1',ordenacao='10',obrigatorio='0'
						WHERE id_servico_campo='3';
--05/07/2011 20:38:49
UPDATE vsites_servico_campo SET campo='certidao_finalidade',tipo='text',nome='FINALIDADE DO DOCUMENTO',valor='',largura='470',mascara='',site='1',ordenacao='11',obrigatorio='0'
						WHERE id_servico_campo='575';
--05/07/2011 20:38:49
DELETE FROM vsites_servico_campo WHERE id_servico_campo = '' AND id_servico='29';
--30/08/2011 10:21:10
UPDATE vsites_servico SET dias='', status='Ativo', descricao='Notificação Eletrônica', site='',desc_site='',servico_desc='',site_menu='' WHERE id_servico='17';
--30/08/2011 10:21:10
UPDATE vsites_servico_campo SET campo='certidao_requerente',tipo='text',nome='CLIENTE',valor='',largura='470',mascara='',site='1',ordenacao='1',obrigatorio='0'
						WHERE id_servico_campo='1257';
--30/08/2011 10:21:10
UPDATE vsites_servico_campo SET campo='certidao_nome',tipo='text',nome='NOME DO NOTIFICADO',valor='',largura='470',mascara='',site='1',ordenacao='2',obrigatorio='0'
						WHERE id_servico_campo='789';
--30/08/2011 10:21:10
UPDATE vsites_servico_campo SET campo='certidao_cpf',tipo='text',nome='CPF DO NOTIFICADO',valor='',largura='470',mascara='',site='1',ordenacao='3',obrigatorio='0'
						WHERE id_servico_campo='330';
--30/08/2011 10:21:10
UPDATE vsites_servico_campo SET campo='certidao_rg',tipo='text',nome='RG DO NOTIFICADO',valor='',largura='470',mascara='',site='1',ordenacao='4',obrigatorio='0'
						WHERE id_servico_campo='1185';
--30/08/2011 10:21:10
UPDATE vsites_servico_campo SET campo='certidao_cnpj',tipo='text',nome='CNPJ DO NOTIFICADO',valor='',largura='470',mascara='',site='1',ordenacao='5',obrigatorio='0'
						WHERE id_servico_campo='244';
--30/08/2011 10:21:10
UPDATE vsites_servico_campo SET campo='certidao_endereco',tipo='text',nome='ENDEREÇO DO NOTIFICADO',valor='',largura='470',mascara='',site='1',ordenacao='6',obrigatorio='0'
						WHERE id_servico_campo='1258';
--30/08/2011 10:21:10
INSERT INTO vsites_servico_campo (id_servico, campo, nome, tipo, largura, site, ordenacao) VALUES ('17','certidao_campo_bairro','BAIRRO DO NOTIFICADO','text','470','1','7');
--30/08/2011 10:21:10
UPDATE vsites_servico_campo SET campo='certidao_estado',tipo='text',nome='ESTADO DO NOTIFICADO',valor='',largura='470',mascara='',site='1',ordenacao='8',obrigatorio='0'
						WHERE id_servico_campo='531';
--30/08/2011 10:21:10
UPDATE vsites_servico_campo SET campo='certidao_cidade',tipo='text',nome='CIDADE DO NOTIFICADO',valor='',largura='470',mascara='',site='1',ordenacao='9',obrigatorio='0'
						WHERE id_servico_campo='167';
--30/08/2011 10:21:10
UPDATE vsites_servico_campo SET campo='certidao_campo_cep',tipo='text',nome='CEP DO NOTIFICADO',valor='',largura='470',mascara='',site='1',ordenacao='10',obrigatorio='0'
						WHERE id_servico_campo='1259';
--30/08/2011 10:21:10
UPDATE vsites_servico_campo SET campo='certidao_cartorio',tipo='text',nome='CARTORIO',valor='',largura='470',mascara='',site='1',ordenacao='11',obrigatorio='0'
						WHERE id_servico_campo='57';
--30/08/2011 10:21:10
UPDATE vsites_servico_campo SET campo='certidao_valor',tipo='text',nome='VALOR',valor='',largura='470',mascara='',site='1',ordenacao='12',obrigatorio='0'
						WHERE id_servico_campo='1260';
--30/08/2011 10:21:10
UPDATE vsites_servico_campo SET campo='certidao_cod_agencia',tipo='text',nome='CODIGO DA AGÊNCIA',valor='',largura='470',mascara='',site='1',ordenacao='13',obrigatorio='0'
						WHERE id_servico_campo='1261';
--30/08/2011 10:21:10
UPDATE vsites_servico_campo SET campo='certidao_conta',tipo='text',nome='NÚMERO DA CONTA',valor='',largura='470',mascara='',site='1',ordenacao='14',obrigatorio='0'
						WHERE id_servico_campo='1262';
--30/08/2011 10:21:10
UPDATE vsites_servico_campo SET campo='certidao_modelo',tipo='text',nome='MODELO',valor='',largura='470',mascara='',site='0',ordenacao='15',obrigatorio='0'
						WHERE id_servico_campo='1263';
--30/08/2011 10:21:10
UPDATE vsites_servico_campo SET campo='certidao_numero_not',tipo='text',nome='NÚMERO DO DOCUMENTO',valor='',largura='470',mascara='',site='1',ordenacao='16',obrigatorio='0'
						WHERE id_servico_campo='1264';
--30/08/2011 10:21:10
UPDATE vsites_servico_campo SET campo='certidao_nosso_numero',tipo='text',nome='NOSSO NÚMERO',valor='',largura='470',mascara='',site='1',ordenacao='17',obrigatorio='0'
						WHERE id_servico_campo='1265';
--30/08/2011 10:21:10
UPDATE vsites_servico_campo SET campo='certidao_duplicata',tipo='text',nome='DUPLICATA',valor='',largura='470',mascara='',site='1',ordenacao='18',obrigatorio='0'
						WHERE id_servico_campo='1266';
--30/08/2011 10:21:10
UPDATE vsites_servico_campo SET campo='certidao_emissao',tipo='text',nome='EMISSÃO',valor='',largura='470',mascara='',site='1',ordenacao='19',obrigatorio='0'
						WHERE id_servico_campo='1267';
--30/08/2011 10:21:10
UPDATE vsites_servico_campo SET campo='certidao_agencia',tipo='text',nome='AGÊNCIA',valor='',largura='470',mascara='',site='1',ordenacao='20',obrigatorio='0'
						WHERE id_servico_campo='1268';
--30/08/2011 10:21:10
UPDATE vsites_servico_campo SET campo='certidao_banco',tipo='text',nome='BANCO COBRADOR',valor='',largura='470',mascara='',site='1',ordenacao='21',obrigatorio='0'
						WHERE id_servico_campo='1269';
--30/08/2011 10:21:10
UPDATE vsites_servico_campo SET campo='certidao_vencimento',tipo='text',nome='VENCIMENTO',valor='',largura='470',mascara='',site='1',ordenacao='22',obrigatorio='0'
						WHERE id_servico_campo='1270';
--30/08/2011 10:21:10
UPDATE vsites_servico_campo SET campo='certidao_cart_titulo',tipo='text',nome='CARTEIRA DO TÍTULO',valor='',largura='470',mascara='',site='1',ordenacao='23',obrigatorio='0'
						WHERE id_servico_campo='1271';
--30/08/2011 10:21:10
UPDATE vsites_servico_campo SET campo='certidao_emissao_dir_cred',tipo='text',nome='EMISSÃO DO DIREITO CRED',valor='',largura='470',mascara='',site='0',ordenacao='24',obrigatorio='0'
						WHERE id_servico_campo='1273';
--30/08/2011 10:21:10
UPDATE vsites_servico_campo SET campo='certidao_num_dir_cred',tipo='text',nome='NÚMERO DIREITO CRED',valor='',largura='470',mascara='',site='0',ordenacao='25',obrigatorio='0'
						WHERE id_servico_campo='1274';
--30/08/2011 10:21:10
UPDATE vsites_servico_campo SET campo='certidao_num_contrato_dir_cred',tipo='text',nome='CONTRATO DO DIREITO CRED',valor='',largura='470',mascara='',site='0',ordenacao='26',obrigatorio='0'
						WHERE id_servico_campo='1275';
--30/08/2011 10:21:10
UPDATE vsites_servico_campo SET campo='certidao_emissao_contrato',tipo='text',nome='EMISSÃO DO CONTRATO',valor='',largura='470',mascara='',site='0',ordenacao='27',obrigatorio='0'
						WHERE id_servico_campo='1276';
--30/08/2011 10:21:10
UPDATE vsites_servico_campo SET campo='certidao_modalidade',tipo='text',nome='MODALIDADE',valor='',largura='470',mascara='',site='0',ordenacao='28',obrigatorio='0'
						WHERE id_servico_campo='1277';
--30/08/2011 10:21:10
UPDATE vsites_servico_campo SET campo='certidao_objeto_contrato_cred',tipo='text',nome='OBJETO DO CONTRATO DIR CRED',valor='',largura='470',mascara='',site='0',ordenacao='29',obrigatorio='0'
						WHERE id_servico_campo='1278';
--30/08/2011 10:21:10
UPDATE vsites_servico_campo SET campo='certidao_cpf_contratado',tipo='text',nome='CPF CONTRATADO',valor='',largura='470',mascara='',site='0',ordenacao='30',obrigatorio='0'
						WHERE id_servico_campo='1279';
--30/08/2011 10:21:10
UPDATE vsites_servico_campo SET campo='certidao_data_protocolo',tipo='text',nome='Data do Protocolo',valor='',largura='470',mascara='',site='0',ordenacao='31',obrigatorio='0'
						WHERE id_servico_campo='1280';
--30/08/2011 10:21:10
UPDATE vsites_servico_campo SET campo='certidao_protocolo',tipo='text',nome='PROTOCOLO',valor='',largura='470',mascara='',site='0',ordenacao='32',obrigatorio='0'
						WHERE id_servico_campo='1005';
--30/08/2011 10:21:10
UPDATE vsites_servico_campo SET campo='certidao_ocorrencia',tipo='text',nome='Ocorrencia',valor='',largura='470',mascara='',site='0',ordenacao='33',obrigatorio='0'
						WHERE id_servico_campo='1282';
--30/08/2011 10:21:10
UPDATE vsites_servico_campo SET campo='certidao_data_ocorrencia',tipo='text',nome='Data da Ocorrencia',valor='',largura='470',mascara='',site='0',ordenacao='34',obrigatorio='0'
						WHERE id_servico_campo='1283';
--30/08/2011 10:21:10
UPDATE vsites_servico_campo SET campo='certidao_registro',tipo='text',nome='Registro',valor='',largura='470',mascara='',site='0',ordenacao='35',obrigatorio='0'
						WHERE id_servico_campo='1284';
--30/08/2011 10:21:10
UPDATE vsites_servico_campo SET campo='certidao_data_registro',tipo='text',nome='Data do Registro',valor='',largura='470',mascara='',site='0',ordenacao='36',obrigatorio='0'
						WHERE id_servico_campo='1285';
--30/08/2011 10:21:10
UPDATE vsites_servico_campo SET campo='certidao_numero_ar',tipo='text',nome='Numero da Ar',valor='',largura='470',mascara='',site='0',ordenacao='37',obrigatorio='0'
						WHERE id_servico_campo='1281';
--30/08/2011 10:21:10
UPDATE vsites_servico_campo SET campo='conce_endereco',tipo='text',nome='CONCESSIONARIA ENDERECO',valor='',largura='470',mascara='',site='0',ordenacao='38',obrigatorio='0'
						WHERE id_servico_campo='1370';
--30/08/2011 10:21:10
UPDATE vsites_servico_campo SET campo='conce_bairro',tipo='text',nome='CONCESSIONARIA BAIRRO',valor='',largura='470',mascara='',site='0',ordenacao='39',obrigatorio='0'
						WHERE id_servico_campo='1371';
--30/08/2011 10:21:10
UPDATE vsites_servico_campo SET campo='conce_cidade',tipo='text',nome='CONCESSIONARIA CIDADE',valor='',largura='470',mascara='',site='0',ordenacao='40',obrigatorio='0'
						WHERE id_servico_campo='1372';
--30/08/2011 10:21:10
UPDATE vsites_servico_campo SET campo='conce_cep',tipo='text',nome='CONCESSIONARIA CEP',valor='',largura='470',mascara='',site='0',ordenacao='41',obrigatorio='0'
						WHERE id_servico_campo='1373';
--30/08/2011 10:21:10
UPDATE vsites_servico_campo SET campo='conce_estado',tipo='text',nome='CONCESSIONARIA ESTADO',valor='',largura='470',mascara='',site='0',ordenacao='42',obrigatorio='0'
						WHERE id_servico_campo='1374';
--30/08/2011 10:21:10
UPDATE vsites_servico_campo SET campo='conce_tel',tipo='text',nome='CONCESSIONARIA TEL',valor='',largura='470',mascara='',site='0',ordenacao='43',obrigatorio='0'
						WHERE id_servico_campo='1375';
--30/08/2011 10:21:10
UPDATE vsites_servico_campo SET campo='conce_nome',tipo='text',nome='CONCESSIONARIA',valor='',largura='470',mascara='',site='0',ordenacao='44',obrigatorio='0'
						WHERE id_servico_campo='1369';
--30/08/2011 10:21:10
UPDATE vsites_servico_campo SET campo='n_parcelas',tipo='text',nome='N PARCELAS',valor='',largura='470',mascara='',site='0',ordenacao='45',obrigatorio='0'
						WHERE id_servico_campo='1368';
--30/08/2011 10:21:10
UPDATE vsites_servico_campo SET campo='c_tel',tipo='text',nome='TEL DO CLIENTE',valor='',largura='470',mascara='',site='0',ordenacao='46',obrigatorio='0'
						WHERE id_servico_campo='1367';
--30/08/2011 10:21:10
UPDATE vsites_servico_campo SET campo='c_estado',tipo='text',nome='ESTADO DO CLIENTE',valor='',largura='470',mascara='',site='0',ordenacao='47',obrigatorio='0'
						WHERE id_servico_campo='1366';
--30/08/2011 10:21:10
UPDATE vsites_servico_campo SET campo='c_cep',tipo='text',nome='CEP DO CLIENTE',valor='',largura='470',mascara='',site='0',ordenacao='48',obrigatorio='0'
						WHERE id_servico_campo='1365';
--30/08/2011 10:21:10
UPDATE vsites_servico_campo SET campo='c_cidade',tipo='text',nome='CIDADE DO CLIENTE',valor='',largura='470',mascara='',site='0',ordenacao='49',obrigatorio='0'
						WHERE id_servico_campo='1364';
--30/08/2011 10:21:10
UPDATE vsites_servico_campo SET campo='c_bairro',tipo='text',nome='BAIRRO DO CLIENTE',valor='',largura='470',mascara='',site='0',ordenacao='50',obrigatorio='0'
						WHERE id_servico_campo='1363';
--30/08/2011 10:21:10
UPDATE vsites_servico_campo SET campo='c_endereco',tipo='text',nome='ENDERECO DO CLIENTE',valor='',largura='470',mascara='',site='0',ordenacao='51',obrigatorio='0'
						WHERE id_servico_campo='1362';
--30/08/2011 10:21:10
UPDATE vsites_servico_campo SET campo='certidao_n_contrato',tipo='text',nome='NUMERO DO CONTRATO',valor='',largura='470',mascara='',site='1',ordenacao='52',obrigatorio='0'
						WHERE id_servico_campo='850';
--30/08/2011 10:21:10
DELETE FROM vsites_servico_campo WHERE id_servico_campo = '' AND id_servico='17';
--13/09/2011 18:24:53
INSERT INTO vsites_servico (id_departamento, status, site, descricao, desc_site, servico_desc, site_menu) VALUES ('2','Ativo','','Habilitação','Habilitação de Casamento','','');
--13/09/2011 18:24:53
INSERT INTO vsites_servico_campo (id_servico, campo, nome, tipo, largura, site, ordenacao) VALUES ('199','certidao_nome','NOME','text','470','0','1');
--13/09/2011 18:24:53
INSERT INTO vsites_servico_campo (id_servico, campo, nome, tipo, largura, site, ordenacao) VALUES ('199','certidao_cpf','CPF','text','470','0','2');
--13/09/2011 18:24:53
INSERT INTO vsites_servico_campo (id_servico, campo, nome, tipo, largura, site, ordenacao) VALUES ('199','certidao_conjuge','CONJUGE','text','470','0','3');
--13/09/2011 18:24:53
INSERT INTO vsites_servico_campo (id_servico, campo, nome, tipo, largura, site, ordenacao) VALUES ('199','certidao_documento_autenticado','DOCUMENTO','text','470','0','4');
--13/09/2011 18:25:14
UPDATE vsites_servico SET dias='', status='Ativo', descricao='Habilitação de Casamento', site='',desc_site='Habilitação de Casamento',servico_desc='',site_menu='' WHERE id_servico='199';
--13/09/2011 18:25:14
UPDATE vsites_servico_campo SET campo='certidao_nome',tipo='text',nome='NOME',valor='',largura='470',mascara='',site='0',ordenacao='1',obrigatorio='0'
						WHERE id_servico_campo='1719';
--13/09/2011 18:25:14
UPDATE vsites_servico_campo SET campo='certidao_cpf',tipo='text',nome='CPF',valor='',largura='470',mascara='',site='0',ordenacao='2',obrigatorio='0'
						WHERE id_servico_campo='1720';
--13/09/2011 18:25:14
UPDATE vsites_servico_campo SET campo='certidao_conjuge',tipo='text',nome='CONJUGE',valor='',largura='470',mascara='',site='0',ordenacao='3',obrigatorio='0'
						WHERE id_servico_campo='1721';
--13/09/2011 18:25:14
UPDATE vsites_servico_campo SET campo='certidao_documento_autenticado',tipo='text',nome='DOCUMENTO',valor='',largura='470',mascara='',site='0',ordenacao='4',obrigatorio='0'
						WHERE id_servico_campo='1722';
--13/09/2011 18:25:14
DELETE FROM vsites_servico_campo WHERE id_servico_campo = '' AND id_servico='199';
--14/09/2011 10:28:25
UPDATE vsites_servico SET dias='', status='Ativo', descricao='Cidadania', site='1',desc_site='Cidadania',servico_desc='Cidadania Espanhola, Cidadania Italiana, Cidadania Portuguesa e de outros paises. Entre em contato e faça seu pedido.

',site_menu='1' WHERE id_servico='78';
--14/09/2011 10:28:25
UPDATE vsites_servico_campo SET campo='certidao_cidade',tipo='text',nome='CIDADE',valor='',largura='470',mascara='',site='1',ordenacao='1',obrigatorio='0'
						WHERE id_servico_campo='124';
--14/09/2011 10:28:25
UPDATE vsites_servico_campo SET campo='certidao_nome',tipo='text',nome='NOME',valor='',largura='470',mascara='',site='1',ordenacao='2',obrigatorio='0'
						WHERE id_servico_campo='747';
--14/09/2011 10:28:25
UPDATE vsites_servico_campo SET campo='certidao_pai',tipo='text',nome='PAI',valor='',largura='470',mascara='',site='1',ordenacao='3',obrigatorio='0'
						WHERE id_servico_campo='908';
--14/09/2011 10:28:25
UPDATE vsites_servico_campo SET campo='certidao_mae',tipo='text',nome='MAE',valor='',largura='470',mascara='',site='1',ordenacao='4',obrigatorio='0'
						WHERE id_servico_campo='642';
--14/09/2011 10:28:25
UPDATE vsites_servico_campo SET campo='certidao_existe_certidao_obito',tipo='text',nome='EXISTE CERTIDAO DE OBITO',valor='',largura='470',mascara='',site='1',ordenacao='5',obrigatorio='0'
						WHERE id_servico_campo='571';
--14/09/2011 10:28:25
UPDATE vsites_servico_campo SET campo='certidao_data_nascimento',tipo='text',nome='DATA DE NASCIMENTO',valor='',largura='470',mascara='',site='1',ordenacao='6',obrigatorio='0'
						WHERE id_servico_campo='388';
--14/09/2011 10:28:25
UPDATE vsites_servico_campo SET campo='certidao_nome_estrangeiro',tipo='text',nome='NOME DO ESTRANGEIRO',valor='',largura='470',mascara='',site='1',ordenacao='7',obrigatorio='0'
						WHERE id_servico_campo='826';
--14/09/2011 10:28:25
UPDATE vsites_servico_campo SET campo='certidao_naturalizado',tipo='text',nome='E NATURALIZADO (sim ou não)',valor='',largura='470',mascara='',site='1',ordenacao='8',obrigatorio='0'
						WHERE id_servico_campo='432';
--14/09/2011 10:28:25
UPDATE vsites_servico_campo SET campo='certidao_protocolo',tipo='text',nome='PROVINCIA OU CIDADE DE',valor='',largura='470',mascara='',site='0',ordenacao='9',obrigatorio='0'
						WHERE id_servico_campo='1033';
--14/09/2011 10:28:25
UPDATE vsites_servico_campo SET campo='certidao_filiacao',tipo='text',nome='FILIACAO',valor='',largura='470',mascara='',site='1',ordenacao='10',obrigatorio='0'
						WHERE id_servico_campo='573';
--14/09/2011 10:28:25
UPDATE vsites_servico_campo SET campo='certidao_existe_certidao_de2',tipo='text',nome='EXISTE CERTIDAO DE',valor='',largura='470',mascara='',site='1',ordenacao='11',obrigatorio='0'
						WHERE id_servico_campo='570';
--14/09/2011 10:28:25
UPDATE vsites_servico_campo SET campo='certidao_existe_certidao_de1',tipo='text',nome='EXISTE CERTIDAO DE',valor='',largura='470',mascara='',site='1',ordenacao='12',obrigatorio='0'
						WHERE id_servico_campo='569';
--14/09/2011 10:28:25
UPDATE vsites_servico_campo SET campo='certidao_data_naturalizacao',tipo='text',nome='DATA DE NATURALIZAÇÃO',valor='',largura='470',mascara='',site='1',ordenacao='13',obrigatorio='0'
						WHERE id_servico_campo='412';
--14/09/2011 10:28:25
UPDATE vsites_servico_campo SET campo='certidao_data_desembarque',tipo='text',nome='DATA DE DESEMBARQUE DO',valor='',largura='470',mascara='',site='1',ordenacao='14',obrigatorio='0'
						WHERE id_servico_campo='370';
--14/09/2011 10:28:25
UPDATE vsites_servico_campo SET campo='certidao_cidade_do_estrangeiro',tipo='text',nome='CIDADE DO ESTRANGEIRO',valor='',largura='470',mascara='',site='1',ordenacao='15',obrigatorio='0'
						WHERE id_servico_campo='204';
--14/09/2011 10:28:25
UPDATE vsites_servico_campo SET campo='certidao_provincia_regiao',tipo='text',nome='PROVINCIA REGIAO DO',valor='',largura='470',mascara='',site='1',ordenacao='16',obrigatorio='0'
						WHERE id_servico_campo='1035';
--14/09/2011 10:28:25
DELETE FROM vsites_servico_campo WHERE id_servico_campo = '' AND id_servico='78';
--06/10/2011 21:02:57
UPDATE vsites_servico SET dias='', status='Ativo', descricao='Protesto de Cheques', site='1',desc_site='',servico_desc='',site_menu='' WHERE id_servico='15';
--06/10/2011 21:02:58
UPDATE vsites_servico_campo SET campo='certidao_nome',tipo='text',nome='CREDOR',valor='',largura='470',mascara='',site='1',ordenacao='1',obrigatorio='1'
						WHERE id_servico_campo='796';
--06/10/2011 21:02:58
UPDATE vsites_servico_campo SET campo='certidao_cpf',tipo='text',nome='CPF',valor='',largura='470',mascara='',site='1',ordenacao='2',obrigatorio='0'
						WHERE id_servico_campo='335';
--06/10/2011 21:02:58
UPDATE vsites_servico_campo SET campo='certidao_cnpj',tipo='text',nome='CNPJ',valor='',largura='470',mascara='',site='1',ordenacao='3',obrigatorio='0'
						WHERE id_servico_campo='249';
--06/10/2011 21:02:58
INSERT INTO vsites_servico_campo (id_servico, campo, nome, tipo, largura, site, ordenacao) VALUES ('15','certidao_devedor','DEVEDOR','text','470','1','4');
--06/10/2011 21:02:58
INSERT INTO vsites_servico_campo (id_servico, campo, nome, tipo, largura, site, ordenacao) VALUES ('15','certidao_devedor_cpf','CPF/CNPJ DEVEDOR','text','470','1','5');
--06/10/2011 21:02:58
UPDATE vsites_servico_campo SET campo='certidao_campo_cep',tipo='text',nome='CEP',valor='',largura='470',mascara='',site='1',ordenacao='6',obrigatorio='0'
						WHERE id_servico_campo='87';
--06/10/2011 21:02:58
UPDATE vsites_servico_campo SET campo='certidao_endereco',tipo='text',nome='ENDERECO',valor='',largura='470',mascara='',site='1',ordenacao='7',obrigatorio='0'
						WHERE id_servico_campo='441';
--06/10/2011 21:02:58
UPDATE vsites_servico_campo SET campo='certidao_estado',tipo='text',nome='Estado',valor='',largura='470',mascara='',site='1',ordenacao='8',obrigatorio='1'
						WHERE id_servico_campo='1376';
--06/10/2011 21:02:58
UPDATE vsites_servico_campo SET campo='certidao_cidade',tipo='text',nome='Cidade',valor='',largura='470',mascara='',site='1',ordenacao='9',obrigatorio='1'
						WHERE id_servico_campo='1307';
--06/10/2011 21:02:58
UPDATE vsites_servico_campo SET campo='certidao_numero_cheque',tipo='text',nome='NUMERO DO CHEQUE',valor='',largura='470',mascara='',site='1',ordenacao='10',obrigatorio='1'
						WHERE id_servico_campo='847';
--06/10/2011 21:02:58
UPDATE vsites_servico_campo SET campo='certidao_data_emissao',tipo='text',nome='DATA DE EMISSAO',valor='',largura='470',mascara='',site='1',ordenacao='11',obrigatorio='0'
						WHERE id_servico_campo='371';
--06/10/2011 21:02:58
UPDATE vsites_servico_campo SET campo='certidao_protocolo',tipo='text',nome='PROTOCOLO',valor='',largura='470',mascara='',site='1',ordenacao='12',obrigatorio='0'
						WHERE id_servico_campo='1308';
--06/10/2011 21:02:58
UPDATE vsites_servico_campo SET campo='certidao_praca',tipo='text',nome='PRAÇA',valor='',largura='470',mascara='',site='1',ordenacao='13',obrigatorio='0'
						WHERE id_servico_campo='1306';
--06/10/2011 21:02:58
UPDATE vsites_servico_campo SET campo='certidao_valor',tipo='text',nome='VALOR',valor='',largura='470',mascara='',site='1',ordenacao='14',obrigatorio='0'
						WHERE id_servico_campo='1236';
--06/10/2011 21:02:58
UPDATE vsites_servico_campo SET campo='certidao_banco_sacado',tipo='text',nome='BANCO SACADO',valor='',largura='470',mascara='',site='1',ordenacao='15',obrigatorio='0'
						WHERE id_servico_campo='20';
--06/10/2011 21:02:58
DELETE FROM vsites_servico_campo WHERE id_servico_campo = '' AND id_servico='15';
--11/04/2012 14:17:57
UPDATE vsites_servico SET dias='', status='Ativo', descricao='Certidão de Distribuições Criminais', site='1',desc_site='Certidão de Distribuições Criminais',servico_desc='<P>
Realizamos a busca da certidão Distribuição Criminal que tem por objetivo identificar se o solicitante possui registros criminais.
</P>',site_menu='1' WHERE id_servico='13';
--11/04/2012 14:17:57
UPDATE vsites_servico_campo SET campo='certidao_nome',tipo='text',nome='NOME',valor='',largura='470',mascara='',site='1',ordenacao='1',obrigatorio='1'
						WHERE id_servico_campo='764';
--11/04/2012 14:17:57
UPDATE vsites_servico_campo SET campo='certidao_data_nascimento',tipo='text',nome='DATA DE NASCIMENTO',valor='',largura='470',mascara='',site='1',ordenacao='2',obrigatorio='1'
						WHERE id_servico_campo='395';
--11/04/2012 14:17:57
UPDATE vsites_servico_campo SET campo='certidao_rg',tipo='text',nome='RG',valor='',largura='470',mascara='',site='1',ordenacao='3',obrigatorio='1'
						WHERE id_servico_campo='1162';
--11/04/2012 14:17:57
UPDATE vsites_servico_campo SET campo='certidao_orgao_emissor',tipo='text',nome='ORGAO EMISSOR',valor='',largura='470',mascara='',site='1',ordenacao='4',obrigatorio='1'
						WHERE id_servico_campo='891';
--11/04/2012 14:17:57
UPDATE vsites_servico_campo SET campo='certidao_cpf',tipo='text',nome='CPF',valor='',largura='470',mascara='',site='1',ordenacao='5',obrigatorio='1'
						WHERE id_servico_campo='310';
--11/04/2012 14:17:57
UPDATE vsites_servico_campo SET campo='certidao_cnpj',tipo='text',nome='CNPJ',valor='',largura='470',mascara='',site='1',ordenacao='6',obrigatorio='0'
						WHERE id_servico_campo='228';
--11/04/2012 14:17:57
UPDATE vsites_servico_campo SET campo='certidao_nacionalidade',tipo='text',nome='NATURALIDADE',valor='',largura='470',mascara='',site='1',ordenacao='7',obrigatorio='1'
						WHERE id_servico_campo='720';
--11/04/2012 14:17:57
UPDATE vsites_servico_campo SET campo='certidao_estado',tipo='text',nome='ESTADO',valor='',largura='470',mascara='',site='1',ordenacao='8',obrigatorio='1'
						WHERE id_servico_campo='503';
--11/04/2012 14:17:57
UPDATE vsites_servico_campo SET campo='certidao_cidade',tipo='text',nome='CIDADE',valor='',largura='470',mascara='',site='1',ordenacao='9',obrigatorio='1'
						WHERE id_servico_campo='139';
--11/04/2012 14:17:57
UPDATE vsites_servico_campo SET campo='certidao_mae',tipo='text',nome='MAE',valor='',largura='470',mascara='',site='1',ordenacao='10',obrigatorio='1'
						WHERE id_servico_campo='647';
--11/04/2012 14:17:57
UPDATE vsites_servico_campo SET campo='certidao_pai',tipo='text',nome='PAI',valor='',largura='470',mascara='',site='1',ordenacao='11',obrigatorio='0'
						WHERE id_servico_campo='913';
--11/04/2012 14:17:57
UPDATE vsites_servico_campo SET campo='certidao_protocolo',tipo='text',nome='PROTOCOLO',valor='',largura='470',mascara='',site='0',ordenacao='12',obrigatorio='0'
						WHERE id_servico_campo='983';
--11/04/2012 14:17:57
DELETE FROM vsites_servico_campo WHERE id_servico_campo = '' AND id_servico='13';
--25/10/2012 09:04:26
INSERT INTO vsites_servico (id_departamento, status, site, descricao, desc_site, servico_desc, site_menu) VALUES ('7','Ativo','','Financiamento Imobiliário','Financiamento Imobiliário','','');
--25/10/2012 09:04:26
INSERT INTO vsites_servico_campo (id_servico, campo, nome, tipo, largura, site, ordenacao) VALUES ('200','certidao_nome','NOME','text','470','1','1');
--25/10/2012 09:08:58
UPDATE vsites_servico SET dias='', status='Ativo', descricao='Financiamento Imobiliário', site='',desc_site='Financiamento Imobiliário',servico_desc='',site_menu='' WHERE id_servico='200';
--25/10/2012 09:08:58
UPDATE vsites_servico_campo SET campo='certidao_nome',tipo='text',nome='NOME',valor='',largura='470',mascara='',site='1',ordenacao='1',obrigatorio='1'
						WHERE id_servico_campo='1725';
--25/10/2012 09:08:58
INSERT INTO vsites_servico_campo (id_servico, campo, nome, tipo, largura, site, ordenacao) VALUES ('200','certidao_rg','RG','text','470','1','2');
--25/10/2012 09:08:58
INSERT INTO vsites_servico_campo (id_servico, campo, nome, tipo, largura, site, ordenacao) VALUES ('200','certidao_cpf','CPF','text','470','1','3');
--25/10/2012 09:08:58
INSERT INTO vsites_servico_campo (id_servico, campo, nome, tipo, largura, site, ordenacao) VALUES ('200','certidao_endereco_imovel','ENDEREÇO','text','470','1','4');
--25/10/2012 09:08:58
INSERT INTO vsites_servico_campo (id_servico, campo, nome, tipo, largura, site, ordenacao) VALUES ('200','certidao_valor_compra_do_imovel','VALOR DO IMÓVEL','text','470','1','5');
--25/10/2012 09:08:58
INSERT INTO vsites_servico_campo (id_servico, campo, nome, tipo, largura, site, ordenacao) VALUES ('200','certidao_requerente','TIPO DE FECHAMENTO','text','470','1','6');
--25/10/2012 09:08:59
DELETE FROM vsites_servico_campo WHERE id_servico_campo = '' AND id_servico='200';
--03/12/2012 11:34:25
UPDATE vsites_servico SET dias='', status='Ativo', descricao='Financiamento Imobiliário', site='',desc_site='Financiamento Imobiliário',servico_desc='',site_menu='' WHERE id_servico='200';
--03/12/2012 11:34:25
UPDATE vsites_servico_campo SET campo='certidao_nome',tipo='text',nome='NOME',valor='',largura='470',mascara='',site='1',ordenacao='1',obrigatorio='1'
						WHERE id_servico_campo='1725';
--03/12/2012 11:34:25
UPDATE vsites_servico_campo SET campo='certidao_rg',tipo='text',nome='RG',valor='',largura='470',mascara='',site='1',ordenacao='2',obrigatorio='0'
						WHERE id_servico_campo='1726';
--03/12/2012 11:34:25
UPDATE vsites_servico_campo SET campo='certidao_cpf',tipo='text',nome='CPF',valor='',largura='470',mascara='',site='1',ordenacao='3',obrigatorio='0'
						WHERE id_servico_campo='1727';
--03/12/2012 11:34:25
UPDATE vsites_servico_campo SET campo='certidao_endereco_imovel',tipo='text',nome='ENDEREÇO',valor='',largura='470',mascara='',site='1',ordenacao='4',obrigatorio='0'
						WHERE id_servico_campo='1728';
--03/12/2012 11:34:25
UPDATE vsites_servico_campo SET campo='certidao_valor_compra_do_imovel',tipo='text',nome='VALOR DO IMOVEL',valor='',largura='470',mascara='',site='1',ordenacao='5',obrigatorio='0'
						WHERE id_servico_campo='1729';
--03/12/2012 11:34:25
INSERT INTO vsites_servico_campo (id_servico, campo, nome, tipo, largura, site, ordenacao) VALUES ('200','certidao_n_processo','VALOR DO FINANCIAMENTO','text','470','0','6');
--03/12/2012 11:34:25
INSERT INTO vsites_servico_campo (id_servico, campo, nome, tipo, largura, site, ordenacao) VALUES ('200','certidao_data','DATA DA FORMALIZAÇÃO','text','470','0','7');
--03/12/2012 11:34:25
INSERT INTO vsites_servico_campo (id_servico, campo, nome, tipo, largura, site, ordenacao) VALUES ('200','certidao_cartorio','DESPACHO DA OPERAÇÃO','text','470','0','8');
--03/12/2012 11:34:25
UPDATE vsites_servico_campo SET campo='certidao_requerente',tipo='text',nome='TIPO DE FECHAMENTO',valor='',largura='470',mascara='',site='1',ordenacao='9',obrigatorio='0'
						WHERE id_servico_campo='1730';
--03/12/2012 11:34:25
DELETE FROM vsites_servico_campo WHERE id_servico_campo = '' AND id_servico='200';
--21/12/2012 12:15:39
INSERT INTO vsites_servico (id_departamento, status, site, descricao, desc_site, servico_desc, site_menu) VALUES ('7','Ativo','','Laudo de Vistoria do Imóvel','','','');
--21/12/2012 12:15:39
INSERT INTO vsites_servico_campo (id_servico, campo, nome, tipo, largura, site, ordenacao) VALUES ('201','certidao_tipo','TIPO','text','470','0','1');
--21/12/2012 12:15:39
INSERT INTO vsites_servico_campo (id_servico, campo, nome, tipo, largura, site, ordenacao) VALUES ('201','certidao_endereco','ENDEREÇO','text','470','0','2');
--21/12/2012 12:15:39
INSERT INTO vsites_servico_campo (id_servico, campo, nome, tipo, largura, site, ordenacao) VALUES ('201','certidao_numero','NÚMERO','text','470','0','3');
--21/12/2012 12:15:39
INSERT INTO vsites_servico_campo (id_servico, campo, nome, tipo, largura, site, ordenacao) VALUES ('201','certidao_campo_bairro','BAIRRO','text','470','0','4');
--21/12/2012 12:15:39
INSERT INTO vsites_servico_campo (id_servico, campo, nome, tipo, largura, site, ordenacao) VALUES ('201','certidao_cidade','CIDADE','text','470','0','5');
--21/12/2012 12:15:39
INSERT INTO vsites_servico_campo (id_servico, campo, nome, tipo, largura, site, ordenacao) VALUES ('201','certidao_estado','ESTADO','text','470','0','6');
--21/12/2012 12:15:39
INSERT INTO vsites_servico_campo (id_servico, campo, nome, tipo, largura, site, ordenacao) VALUES ('201','certidao_campo_cep','CEP','text','470','0','7');
--21/12/2012 12:15:39
INSERT INTO vsites_servico_campo (id_servico, campo, nome, tipo, largura, site, ordenacao) VALUES ('201','certidao_n_processo','DOCUMENTOS','text','470','0','8');
--08/01/2013 16:25:42
UPDATE vsites_servico SET dias='', status='Ativo', descricao='Distribuidor Civel', site='1',desc_site='Distribuidor Civel',servico_desc='<p>
Certidão emitida averiguando se constam ou não, ações cíveis.
Exemplos: Separação, divorcio, condomínio, despejo, cobrança etc. Solicita-se normalmente para compra e venda de imóvel.
Documentos necessários para solicitação; Pessoa Física; Informar nome completo, RG, CPF e para qual finalidade é a certidão. Pessoa Jurídica: Informar nome completo, CNPJ e para qual finalidade é a certidão.  
</p>',site_menu='1' WHERE id_servico='6';
--08/01/2013 16:25:42
UPDATE vsites_servico_campo SET campo='certidao_nome',tipo='text',nome='NOME',valor='',largura='470',mascara='',site='1',ordenacao='1',obrigatorio='1'
						WHERE id_servico_campo='766';
--08/01/2013 16:25:42
UPDATE vsites_servico_campo SET campo='certidao_rg',tipo='text',nome='RG',valor='',largura='470',mascara='',site='1',ordenacao='2',obrigatorio='0'
						WHERE id_servico_campo='1164';
--08/01/2013 16:25:42
UPDATE vsites_servico_campo SET campo='certidao_cpf',tipo='text',nome='CPF',valor='',largura='470',mascara='',site='1',ordenacao='3',obrigatorio='0'
						WHERE id_servico_campo='312';
--08/01/2013 16:25:42
INSERT INTO vsites_servico_campo (id_servico, campo, nome, tipo, largura, site, ordenacao) VALUES ('6','certidao_estado_civil','ESTADO CIVIL','text','470','1','4');
--08/01/2013 16:25:42
INSERT INTO vsites_servico_campo (id_servico, campo, nome, tipo, largura, site, ordenacao) VALUES ('6','certidao_profissao','PROFISSÃO','text','470','1','5');
--08/01/2013 16:25:42
UPDATE vsites_servico_campo SET campo='certidao_cnpj',tipo='text',nome='CNPJ',valor='',largura='470',mascara='',site='1',ordenacao='6',obrigatorio='0'
						WHERE id_servico_campo='230';
--08/01/2013 16:25:42
UPDATE vsites_servico_campo SET campo='certidao_estado',tipo='text',nome='ESTADO',valor='',largura='470',mascara='',site='1',ordenacao='7',obrigatorio='1'
						WHERE id_servico_campo='505';
--08/01/2013 16:25:42
UPDATE vsites_servico_campo SET campo='certidao_cidade',tipo='text',nome='CIDADE',valor='',largura='470',mascara='',site='1',ordenacao='8',obrigatorio='1'
						WHERE id_servico_campo='141';
--08/01/2013 16:25:42
UPDATE vsites_servico_campo SET campo='certidao_protocolo',tipo='text',nome='PROTOCOLO',valor='',largura='470',mascara='',site='0',ordenacao='9',obrigatorio='0'
						WHERE id_servico_campo='985';
--08/01/2013 16:25:42
DELETE FROM vsites_servico_campo WHERE id_servico_campo = '' AND id_servico='6';
--21/03/2013 17:32:19
UPDATE vsites_servico SET dias='', status='Ativo', descricao='Notificação Eletrônica', site='',desc_site='',servico_desc='',site_menu='' WHERE id_servico='17';
--21/03/2013 17:32:20
UPDATE vsites_servico_campo SET campo='certidao_requerente',tipo='text',nome='CLIENTE',valor='',largura='470',mascara='',site='1',ordenacao='1',obrigatorio='0'
						WHERE id_servico_campo='1257';
--21/03/2013 17:32:20
UPDATE vsites_servico_campo SET campo='certidao_nome',tipo='text',nome='NOME DO NOTIFICADO',valor='',largura='470',mascara='',site='1',ordenacao='2',obrigatorio='0'
						WHERE id_servico_campo='789';
--21/03/2013 17:32:20
UPDATE vsites_servico_campo SET campo='certidao_cpf',tipo='text',nome='CPF DO NOTIFICADO',valor='',largura='470',mascara='',site='1',ordenacao='3',obrigatorio='0'
						WHERE id_servico_campo='330';
--21/03/2013 17:32:20
UPDATE vsites_servico_campo SET campo='certidao_rg',tipo='text',nome='RG DO NOTIFICADO',valor='',largura='470',mascara='',site='1',ordenacao='4',obrigatorio='0'
						WHERE id_servico_campo='1185';
--21/03/2013 17:32:20
UPDATE vsites_servico_campo SET campo='certidao_cnpj',tipo='text',nome='CNPJ DO NOTIFICADO',valor='',largura='470',mascara='',site='1',ordenacao='5',obrigatorio='0'
						WHERE id_servico_campo='244';
--21/03/2013 17:32:20
UPDATE vsites_servico_campo SET campo='certidao_endereco',tipo='text',nome='ENDEREÇO DO NOTIFICADO',valor='',largura='470',mascara='',site='1',ordenacao='6',obrigatorio='0'
						WHERE id_servico_campo='1258';
--21/03/2013 17:32:20
UPDATE vsites_servico_campo SET campo='certidao_campo_bairro',tipo='text',nome='BAIRRO DO NOTIFICADO',valor='',largura='470',mascara='',site='1',ordenacao='7',obrigatorio='0'
						WHERE id_servico_campo='1718';
--21/03/2013 17:32:20
UPDATE vsites_servico_campo SET campo='certidao_estado',tipo='text',nome='ESTADO DO NOTIFICADO',valor='',largura='470',mascara='',site='1',ordenacao='8',obrigatorio='0'
						WHERE id_servico_campo='531';
--21/03/2013 17:32:20
UPDATE vsites_servico_campo SET campo='certidao_cidade',tipo='text',nome='CIDADE DO NOTIFICADO',valor='',largura='470',mascara='',site='1',ordenacao='9',obrigatorio='0'
						WHERE id_servico_campo='167';
--21/03/2013 17:32:20
UPDATE vsites_servico_campo SET campo='certidao_campo_cep',tipo='text',nome='CEP DO NOTIFICADO',valor='',largura='470',mascara='',site='1',ordenacao='10',obrigatorio='0'
						WHERE id_servico_campo='1259';
--21/03/2013 17:32:20
UPDATE vsites_servico_campo SET campo='certidao_cartorio',tipo='text',nome='CARTORIO',valor='',largura='470',mascara='',site='1',ordenacao='11',obrigatorio='0'
						WHERE id_servico_campo='57';
--21/03/2013 17:32:20
UPDATE vsites_servico_campo SET campo='certidao_valor',tipo='text',nome='VALOR',valor='',largura='470',mascara='',site='1',ordenacao='12',obrigatorio='0'
						WHERE id_servico_campo='1260';
--21/03/2013 17:32:20
UPDATE vsites_servico_campo SET campo='certidao_cod_agencia',tipo='text',nome='CODIGO DA AGÊNCIA',valor='',largura='470',mascara='',site='1',ordenacao='13',obrigatorio='0'
						WHERE id_servico_campo='1261';
--21/03/2013 17:32:20
UPDATE vsites_servico_campo SET campo='certidao_conta',tipo='text',nome='NÚMERO DA CONTA',valor='',largura='470',mascara='',site='1',ordenacao='14',obrigatorio='0'
						WHERE id_servico_campo='1262';
--21/03/2013 17:32:20
UPDATE vsites_servico_campo SET campo='certidao_modelo',tipo='text',nome='MODELO',valor='',largura='470',mascara='',site='0',ordenacao='15',obrigatorio='0'
						WHERE id_servico_campo='1263';
--21/03/2013 17:32:20
UPDATE vsites_servico_campo SET campo='certidao_numero_not',tipo='text',nome='NÚMERO DO DOCUMENTO',valor='',largura='470',mascara='',site='1',ordenacao='16',obrigatorio='0'
						WHERE id_servico_campo='1264';
--21/03/2013 17:32:20
UPDATE vsites_servico_campo SET campo='certidao_nosso_numero',tipo='text',nome='NOSSO NÚMERO',valor='',largura='470',mascara='',site='1',ordenacao='17',obrigatorio='0'
						WHERE id_servico_campo='1265';
--21/03/2013 17:32:21
UPDATE vsites_servico_campo SET campo='certidao_duplicata',tipo='text',nome='DUPLICATA',valor='',largura='470',mascara='',site='1',ordenacao='18',obrigatorio='0'
						WHERE id_servico_campo='1266';
--21/03/2013 17:32:21
UPDATE vsites_servico_campo SET campo='certidao_emissao',tipo='text',nome='EMISSÃO',valor='',largura='470',mascara='',site='1',ordenacao='19',obrigatorio='0'
						WHERE id_servico_campo='1267';
--21/03/2013 17:32:21
UPDATE vsites_servico_campo SET campo='certidao_agencia',tipo='text',nome='AGÊNCIA',valor='',largura='470',mascara='',site='1',ordenacao='20',obrigatorio='0'
						WHERE id_servico_campo='1268';
--21/03/2013 17:32:21
UPDATE vsites_servico_campo SET campo='certidao_banco',tipo='text',nome='BANCO COBRADOR',valor='',largura='470',mascara='',site='1',ordenacao='21',obrigatorio='0'
						WHERE id_servico_campo='1269';
--21/03/2013 17:32:21
UPDATE vsites_servico_campo SET campo='certidao_vencimento',tipo='text',nome='VENCIMENTO',valor='',largura='470',mascara='',site='1',ordenacao='22',obrigatorio='0'
						WHERE id_servico_campo='1270';
--21/03/2013 17:32:21
UPDATE vsites_servico_campo SET campo='certidao_cart_titulo',tipo='text',nome='CARTEIRA DO TÍTULO',valor='',largura='470',mascara='',site='1',ordenacao='23',obrigatorio='0'
						WHERE id_servico_campo='1271';
--21/03/2013 17:32:21
UPDATE vsites_servico_campo SET campo='certidao_emissao_dir_cred',tipo='text',nome='EMISSÃO DO DIREITO CRED',valor='',largura='470',mascara='',site='0',ordenacao='24',obrigatorio='0'
						WHERE id_servico_campo='1273';
--21/03/2013 17:32:21
UPDATE vsites_servico_campo SET campo='certidao_num_dir_cred',tipo='text',nome='NÚMERO DIREITO CRED',valor='',largura='470',mascara='',site='0',ordenacao='25',obrigatorio='0'
						WHERE id_servico_campo='1274';
--21/03/2013 17:32:21
UPDATE vsites_servico_campo SET campo='certidao_num_contrato_dir_cred',tipo='text',nome='CONTRATO DO DIREITO CRED',valor='',largura='470',mascara='',site='0',ordenacao='26',obrigatorio='0'
						WHERE id_servico_campo='1275';
--21/03/2013 17:32:21
UPDATE vsites_servico_campo SET campo='certidao_emissao_contrato',tipo='text',nome='EMISSÃO DO CONTRATO',valor='',largura='470',mascara='',site='0',ordenacao='27',obrigatorio='0'
						WHERE id_servico_campo='1276';
--21/03/2013 17:32:21
UPDATE vsites_servico_campo SET campo='certidao_modalidade',tipo='text',nome='MODALIDADE',valor='',largura='470',mascara='',site='0',ordenacao='28',obrigatorio='0'
						WHERE id_servico_campo='1277';
--21/03/2013 17:32:21
UPDATE vsites_servico_campo SET campo='certidao_objeto_contrato_cred',tipo='text',nome='OBJETO DO CONTRATO DIR CRED',valor='',largura='470',mascara='',site='0',ordenacao='29',obrigatorio='0'
						WHERE id_servico_campo='1278';
--21/03/2013 17:32:21
UPDATE vsites_servico_campo SET campo='certidao_cpf_contratado',tipo='text',nome='CPF CONTRATADO',valor='',largura='470',mascara='',site='0',ordenacao='30',obrigatorio='0'
						WHERE id_servico_campo='1279';
--21/03/2013 17:32:21
UPDATE vsites_servico_campo SET campo='certidao_data_protocolo',tipo='text',nome='Data do Protocolo',valor='',largura='470',mascara='',site='0',ordenacao='31',obrigatorio='0'
						WHERE id_servico_campo='1280';
--21/03/2013 17:32:21
UPDATE vsites_servico_campo SET campo='certidao_protocolo',tipo='text',nome='PROTOCOLO',valor='',largura='470',mascara='',site='0',ordenacao='32',obrigatorio='0'
						WHERE id_servico_campo='1005';
--21/03/2013 17:32:21
UPDATE vsites_servico_campo SET campo='certidao_ocorrencia',tipo='text',nome='Ocorrencia',valor='',largura='470',mascara='',site='0',ordenacao='33',obrigatorio='0'
						WHERE id_servico_campo='1282';
--21/03/2013 17:32:21
UPDATE vsites_servico_campo SET campo='certidao_data_ocorrencia',tipo='text',nome='Data da Ocorrencia',valor='',largura='470',mascara='',site='0',ordenacao='34',obrigatorio='0'
						WHERE id_servico_campo='1283';
--21/03/2013 17:32:21
UPDATE vsites_servico_campo SET campo='certidao_registro',tipo='text',nome='Registro',valor='',largura='470',mascara='',site='0',ordenacao='35',obrigatorio='0'
						WHERE id_servico_campo='1284';
--21/03/2013 17:32:21
UPDATE vsites_servico_campo SET campo='certidao_data_registro',tipo='text',nome='Data do Registro',valor='',largura='470',mascara='',site='0',ordenacao='36',obrigatorio='0'
						WHERE id_servico_campo='1285';
--21/03/2013 17:32:21
UPDATE vsites_servico_campo SET campo='certidao_numero_ar',tipo='text',nome='Numero da Ar',valor='',largura='470',mascara='',site='0',ordenacao='37',obrigatorio='0'
						WHERE id_servico_campo='1281';
--21/03/2013 17:32:21
UPDATE vsites_servico_campo SET campo='conce_endereco',tipo='text',nome='CONCESSIONARIA ENDERECO',valor='',largura='470',mascara='',site='0',ordenacao='38',obrigatorio='0'
						WHERE id_servico_campo='1370';
--21/03/2013 17:32:21
UPDATE vsites_servico_campo SET campo='conce_bairro',tipo='text',nome='CONCESSIONARIA BAIRRO',valor='',largura='470',mascara='',site='0',ordenacao='39',obrigatorio='0'
						WHERE id_servico_campo='1371';
--21/03/2013 17:32:22
UPDATE vsites_servico_campo SET campo='conce_cidade',tipo='text',nome='CONCESSIONARIA CIDADE',valor='',largura='470',mascara='',site='0',ordenacao='40',obrigatorio='0'
						WHERE id_servico_campo='1372';
--21/03/2013 17:32:22
UPDATE vsites_servico_campo SET campo='conce_cep',tipo='text',nome='CONCESSIONARIA CEP',valor='',largura='470',mascara='',site='0',ordenacao='41',obrigatorio='0'
						WHERE id_servico_campo='1373';
--21/03/2013 17:32:22
UPDATE vsites_servico_campo SET campo='conce_estado',tipo='text',nome='CONCESSIONARIA ESTADO',valor='',largura='470',mascara='',site='0',ordenacao='42',obrigatorio='0'
						WHERE id_servico_campo='1374';
--21/03/2013 17:32:22
UPDATE vsites_servico_campo SET campo='conce_tel',tipo='text',nome='CONCESSIONARIA TEL',valor='',largura='470',mascara='',site='0',ordenacao='43',obrigatorio='0'
						WHERE id_servico_campo='1375';
--21/03/2013 17:32:22
UPDATE vsites_servico_campo SET campo='conce_nome',tipo='text',nome='CONCESSIONARIA',valor='',largura='470',mascara='',site='0',ordenacao='44',obrigatorio='0'
						WHERE id_servico_campo='1369';
--21/03/2013 17:32:22
UPDATE vsites_servico_campo SET campo='n_parcelas',tipo='text',nome='N PARCELAS',valor='',largura='470',mascara='',site='0',ordenacao='45',obrigatorio='0'
						WHERE id_servico_campo='1368';
--21/03/2013 17:32:22
UPDATE vsites_servico_campo SET campo='c_tel',tipo='text',nome='TEL DO CLIENTE',valor='',largura='470',mascara='',site='0',ordenacao='46',obrigatorio='0'
						WHERE id_servico_campo='1367';
--21/03/2013 17:32:22
UPDATE vsites_servico_campo SET campo='c_estado',tipo='text',nome='ESTADO DO CLIENTE',valor='',largura='470',mascara='',site='0',ordenacao='47',obrigatorio='0'
						WHERE id_servico_campo='1366';
--21/03/2013 17:32:22
UPDATE vsites_servico_campo SET campo='c_cep',tipo='text',nome='CEP DO CLIENTE',valor='',largura='470',mascara='',site='0',ordenacao='48',obrigatorio='0'
						WHERE id_servico_campo='1365';
--21/03/2013 17:32:22
UPDATE vsites_servico_campo SET campo='c_cidade',tipo='text',nome='CIDADE DO CLIENTE',valor='',largura='470',mascara='',site='0',ordenacao='49',obrigatorio='0'
						WHERE id_servico_campo='1364';
--21/03/2013 17:32:22
UPDATE vsites_servico_campo SET campo='c_bairro',tipo='text',nome='BAIRRO DO CLIENTE',valor='',largura='470',mascara='',site='0',ordenacao='50',obrigatorio='0'
						WHERE id_servico_campo='1363';
--21/03/2013 17:32:22
UPDATE vsites_servico_campo SET campo='c_endereco',tipo='text',nome='ENDERECO DO CLIENTE',valor='',largura='470',mascara='',site='0',ordenacao='51',obrigatorio='0'
						WHERE id_servico_campo='1362';
--21/03/2013 17:32:22
UPDATE vsites_servico_campo SET campo='certidao_n_contrato',tipo='text',nome='NUMERO DO CONTRATO',valor='',largura='470',mascara='',site='1',ordenacao='52',obrigatorio='0'
						WHERE id_servico_campo='850';
--21/03/2013 17:32:22
INSERT INTO vsites_servico_campo (id_servico, campo, nome, tipo, largura, site, ordenacao) VALUES ('17','certidao_n_contribuinte','MULTA','text','470','0','53');
--21/03/2013 17:32:22
INSERT INTO vsites_servico_campo (id_servico, campo, nome, tipo, largura, site, ordenacao) VALUES ('17','certidao_n_deposito','JUROS','text','470','0','54');
--21/03/2013 17:32:22
DELETE FROM vsites_servico_campo WHERE id_servico_campo = '' AND id_servico='17';
--12/04/2013 12:36:46
INSERT INTO vsites_servico (id_departamento, status, site, descricao, desc_site, servico_desc, site_menu) VALUES ('4','Ativo','','Interdição de Pessoa Juridica','Interdição de Pessoa Juridica','','');
--12/04/2013 12:36:46
INSERT INTO vsites_servico_campo (id_servico, campo, nome, tipo, largura, site, ordenacao) VALUES ('202','certidao_nome','NOME','text','470','0','1');
--12/04/2013 12:38:52
UPDATE vsites_servico SET dias='', status='Ativo', descricao='Interdição de Pessoa Juridica', site='',desc_site='Interdição de Pessoa Juridica',servico_desc='',site_menu='' WHERE id_servico='202';
--12/04/2013 12:38:52
UPDATE vsites_servico_campo SET campo='certidao_nome',tipo='text',nome='NOME',valor='',largura='470',mascara='',site='0',ordenacao='1',obrigatorio='0'
						WHERE id_servico_campo='1746';
--12/04/2013 12:38:52
INSERT INTO vsites_servico_campo (id_servico, campo, nome, tipo, largura, site, ordenacao) VALUES ('202','certidao_cnpj','CNPJ','text','470','0','2');
--12/04/2013 12:38:52
INSERT INTO vsites_servico_campo (id_servico, campo, nome, tipo, largura, site, ordenacao) VALUES ('202','certidao_endereco_imovel','ENDEREÇO','text','470','0','3');
--12/04/2013 12:38:52
INSERT INTO vsites_servico_campo (id_servico, campo, nome, tipo, largura, site, ordenacao) VALUES ('202','certidao_nome_proprietario','SÓCIO','text','470','0','4');
--12/04/2013 12:38:52
DELETE FROM vsites_servico_campo WHERE id_servico_campo = '' AND id_servico='202';
--12/04/2013 12:58:19
UPDATE vsites_servico SET dias='', status='Ativo', descricao='Interdição de Pessoa Juridica', site='',desc_site='Interdição de Pessoa Juridica',servico_desc='',site_menu='' WHERE id_servico='202';
--12/04/2013 12:58:19
UPDATE vsites_servico_campo SET campo='certidao_nome',tipo='text',nome='NOME',valor='',largura='470',mascara='',site='0',ordenacao='1',obrigatorio='0'
						WHERE id_servico_campo='1746';
--12/04/2013 12:58:19
UPDATE vsites_servico_campo SET campo='certidao_cnpj',tipo='text',nome='CNPJ',valor='',largura='470',mascara='',site='0',ordenacao='2',obrigatorio='0'
						WHERE id_servico_campo='1747';
--12/04/2013 12:58:20
UPDATE vsites_servico_campo SET campo='certidao_nome_proprietario',tipo='text',nome='SÓCIO',valor='',largura='470',mascara='',site='0',ordenacao='3',obrigatorio='0'
						WHERE id_servico_campo='1749';
--12/04/2013 12:58:20
UPDATE vsites_servico_campo SET campo='certidao_endereco_imovel',tipo='text',nome='ENDEREÇO',valor='',largura='470',mascara='',site='0',ordenacao='4',obrigatorio='0'
						WHERE id_servico_campo='1748';
--12/04/2013 12:58:20
DELETE FROM vsites_servico_campo WHERE id_servico_campo = '' AND id_servico='202';
--04/07/2013 16:40:29
UPDATE vsites_servico SET dias='', status='Ativo', descricao='Autenticação Digital', site='',desc_site='',servico_desc='',site_menu='' WHERE id_servico='144';
--04/07/2013 16:40:29
DELETE FROM vsites_servico_campo WHERE id_servico_campo = '' AND id_servico='144';
--07/08/2013 16:09:30
UPDATE vsites_servico SET dias='', status='Ativo', descricao='2º Via de Contrato', site='1',desc_site='',servico_desc='',site_menu='' WHERE id_servico='66';
--07/08/2013 16:09:30
UPDATE vsites_servico_campo SET campo='certidao_nome',tipo='text',nome='NOME',valor='',largura='470',mascara='',site='1',ordenacao='1',obrigatorio='1'
						WHERE id_servico_campo='724';
--07/08/2013 16:09:30
UPDATE vsites_servico_campo SET campo='certidao_rg',tipo='text',nome='RG',valor='',largura='470',mascara='',site='1',ordenacao='2',obrigatorio='0'
						WHERE id_servico_campo='1133';
--07/08/2013 16:09:30
UPDATE vsites_servico_campo SET campo='certidao_cpf',tipo='text',nome='CPF',valor='',largura='470',mascara='',site='1',ordenacao='3',obrigatorio='0'
						WHERE id_servico_campo='282';
--07/08/2013 16:09:30
UPDATE vsites_servico_campo SET campo='certidao_cnpj',tipo='text',nome='CNPJ',valor='',largura='470',mascara='',site='1',ordenacao='4',obrigatorio='0'
						WHERE id_servico_campo='206';
--07/08/2013 16:09:30
UPDATE vsites_servico_campo SET campo='certidao_estado',tipo='text',nome='ESTADO',valor='',largura='470',mascara='',site='1',ordenacao='5',obrigatorio='1'
						WHERE id_servico_campo='1562';
--07/08/2013 16:09:30
UPDATE vsites_servico_campo SET campo='certidao_cidade',tipo='text',nome='CIDADE',valor='',largura='470',mascara='',site='1',ordenacao='6',obrigatorio='1'
						WHERE id_servico_campo='102';
--07/08/2013 16:09:30
UPDATE vsites_servico_campo SET campo='certidao_cartorio',tipo='text',nome='CARTORIO',valor='',largura='470',mascara='',site='1',ordenacao='7',obrigatorio='1'
						WHERE id_servico_campo='22';
--07/08/2013 16:09:30
UPDATE vsites_servico_campo SET campo='certidao_n_contrato',tipo='text',nome='NUMERO DO CONTRATO',valor='',largura='470',mascara='',site='1',ordenacao='8',obrigatorio='1'
						WHERE id_servico_campo='848';
--07/08/2013 16:09:30
DELETE FROM vsites_servico_campo WHERE id_servico_campo = '' AND id_servico='66';
--07/08/2013 16:20:04
UPDATE vsites_servico SET dias='', status='Ativo', descricao='Lavratura e Registro de Escritura', site='1',desc_site='',servico_desc='',site_menu='' WHERE id_servico='105';
--07/08/2013 16:20:04
UPDATE vsites_servico_campo SET campo='certidao_nome',tipo='text',nome='NOME',valor='',largura='470',mascara='',site='1',ordenacao='1',obrigatorio='0'
						WHERE id_servico_campo='780';
--07/08/2013 16:20:04
UPDATE vsites_servico_campo SET campo='certidao_estado',tipo='text',nome='ESTADO',valor='',largura='470',mascara='',site='1',ordenacao='2',obrigatorio='0'
						WHERE id_servico_campo='520';
--07/08/2013 16:20:04
INSERT INTO vsites_servico_campo (id_servico, campo, nome, tipo, largura, site, ordenacao) VALUES ('105','certidao_cidade','CIDADE','text','470','1','3');
--07/08/2013 16:20:04
UPDATE vsites_servico_campo SET campo='certidao_campo_bairro',tipo='text',nome='BAIRRO',valor='',largura='470',mascara='',site='1',ordenacao='4',obrigatorio='0'
						WHERE id_servico_campo='18';
--07/08/2013 16:20:04
UPDATE vsites_servico_campo SET campo='certidao_valor_compra_do_imovel',tipo='text',nome='VALOR DA COMPRA DO IMOVEL',valor='',largura='470',mascara='',site='1',ordenacao='5',obrigatorio='0'
						WHERE id_servico_campo='1241';
--07/08/2013 16:20:04
UPDATE vsites_servico_campo SET campo='certidao_matricula',tipo='text',nome='MATRICULA',valor='',largura='470',mascara='',site='1',ordenacao='6',obrigatorio='0'
						WHERE id_servico_campo='674';
--07/08/2013 16:20:04
UPDATE vsites_servico_campo SET campo='certidao_n_contribuinte',tipo='text',nome='N DO CONTRIBUINTE (IPTU)',valor='',largura='470',mascara='',site='1',ordenacao='7',obrigatorio='0'
						WHERE id_servico_campo='712';
--07/08/2013 16:20:04
UPDATE vsites_servico_campo SET campo='certidao_endereco_empresa',tipo='text',nome='ENDERECO DA EMPRESA',valor='',largura='470',mascara='',site='1',ordenacao='8',obrigatorio='0'
						WHERE id_servico_campo='452';
--07/08/2013 16:20:04
UPDATE vsites_servico_campo SET campo='certidao_cartorio_do_registro',tipo='text',nome='CARTORIO DO REGISTRO DO',valor='',largura='470',mascara='',site='1',ordenacao='9',obrigatorio='0'
						WHERE id_servico_campo='83';
--07/08/2013 16:20:05
UPDATE vsites_servico_campo SET campo='certidao_rg',tipo='text',nome='RG',valor='',largura='470',mascara='',site='1',ordenacao='10',obrigatorio='0'
						WHERE id_servico_campo='1177';
--07/08/2013 16:20:05
UPDATE vsites_servico_campo SET campo='certidao_endereco',tipo='text',nome='ENDERECO',valor='',largura='470',mascara='',site='1',ordenacao='11',obrigatorio='0'
						WHERE id_servico_campo='438';
--07/08/2013 16:20:05
UPDATE vsites_servico_campo SET campo='certidao_cpf',tipo='text',nome='CPF',valor='',largura='470',mascara='',site='1',ordenacao='12',obrigatorio='0'
						WHERE id_servico_campo='325';
--07/08/2013 16:20:05
UPDATE vsites_servico_campo SET campo='certidao_campo_cep',tipo='text',nome='CEP',valor='',largura='470',mascara='',site='1',ordenacao='13',obrigatorio='0'
						WHERE id_servico_campo='85';
--07/08/2013 16:20:05
UPDATE vsites_servico_campo SET campo='certidao_valor_venal',tipo='text',nome='VALOR VENAL DO IMOVEL',valor='',largura='470',mascara='',site='1',ordenacao='14',obrigatorio='0'
						WHERE id_servico_campo='1242';
--07/08/2013 16:20:05
DELETE FROM vsites_servico_campo WHERE id_servico_campo = '' AND id_servico='105';
--07/08/2013 16:24:02
UPDATE vsites_servico SET dias='', status='Ativo', descricao='Cidadania', site='1',desc_site='Cidadania',servico_desc='Cidadania Espanhola, Cidadania Italiana, Cidadania Portuguesa e de outros paises. Entre em contato e faça seu pedido.

',site_menu='1' WHERE id_servico='78';
--07/08/2013 16:24:02
INSERT INTO vsites_servico_campo (id_servico, campo, nome, tipo, largura, site, ordenacao) VALUES ('78','certidao_estado','ESTADO','text','470','1','1');
--07/08/2013 16:24:03
UPDATE vsites_servico_campo SET campo='certidao_cidade',tipo='text',nome='CIDADE',valor='',largura='470',mascara='',site='1',ordenacao='2',obrigatorio='0'
						WHERE id_servico_campo='124';
--07/08/2013 16:24:03
UPDATE vsites_servico_campo SET campo='certidao_nome',tipo='text',nome='NOME',valor='',largura='470',mascara='',site='1',ordenacao='3',obrigatorio='0'
						WHERE id_servico_campo='747';
--07/08/2013 16:24:03
UPDATE vsites_servico_campo SET campo='certidao_pai',tipo='text',nome='PAI',valor='',largura='470',mascara='',site='1',ordenacao='4',obrigatorio='0'
						WHERE id_servico_campo='908';
--07/08/2013 16:24:03
UPDATE vsites_servico_campo SET campo='certidao_mae',tipo='text',nome='MAE',valor='',largura='470',mascara='',site='1',ordenacao='5',obrigatorio='0'
						WHERE id_servico_campo='642';
--07/08/2013 16:24:03
UPDATE vsites_servico_campo SET campo='certidao_existe_certidao_obito',tipo='text',nome='EXISTE CERTIDAO DE OBITO',valor='',largura='470',mascara='',site='1',ordenacao='6',obrigatorio='0'
						WHERE id_servico_campo='571';
--07/08/2013 16:24:03
UPDATE vsites_servico_campo SET campo='certidao_data_nascimento',tipo='text',nome='DATA DE NASCIMENTO',valor='',largura='470',mascara='',site='1',ordenacao='7',obrigatorio='0'
						WHERE id_servico_campo='388';
--07/08/2013 16:24:03
UPDATE vsites_servico_campo SET campo='certidao_nome_estrangeiro',tipo='text',nome='NOME DO ESTRANGEIRO',valor='',largura='470',mascara='',site='1',ordenacao='8',obrigatorio='0'
						WHERE id_servico_campo='826';
--07/08/2013 16:24:03
UPDATE vsites_servico_campo SET campo='certidao_naturalizado',tipo='text',nome='E NATURALIZADO (sim ou não)',valor='',largura='470',mascara='',site='1',ordenacao='9',obrigatorio='0'
						WHERE id_servico_campo='432';
--07/08/2013 16:24:03
UPDATE vsites_servico_campo SET campo='certidao_protocolo',tipo='text',nome='PROVINCIA OU CIDADE DE',valor='',largura='470',mascara='',site='0',ordenacao='10',obrigatorio='0'
						WHERE id_servico_campo='1033';
--07/08/2013 16:24:03
UPDATE vsites_servico_campo SET campo='certidao_filiacao',tipo='text',nome='FILIACAO',valor='',largura='470',mascara='',site='1',ordenacao='11',obrigatorio='0'
						WHERE id_servico_campo='573';
--07/08/2013 16:24:03
UPDATE vsites_servico_campo SET campo='certidao_existe_certidao_de2',tipo='text',nome='EXISTE CERTIDAO DE',valor='',largura='470',mascara='',site='1',ordenacao='12',obrigatorio='0'
						WHERE id_servico_campo='570';
--07/08/2013 16:24:03
UPDATE vsites_servico_campo SET campo='certidao_existe_certidao_de1',tipo='text',nome='EXISTE CERTIDAO DE',valor='',largura='470',mascara='',site='1',ordenacao='13',obrigatorio='0'
						WHERE id_servico_campo='569';
--07/08/2013 16:24:03
UPDATE vsites_servico_campo SET campo='certidao_data_naturalizacao',tipo='text',nome='DATA DE NATURALIZAÇÃO',valor='',largura='470',mascara='',site='1',ordenacao='14',obrigatorio='0'
						WHERE id_servico_campo='412';
--07/08/2013 16:24:03
UPDATE vsites_servico_campo SET campo='certidao_data_desembarque',tipo='text',nome='DATA DE DESEMBARQUE DO',valor='',largura='470',mascara='',site='1',ordenacao='15',obrigatorio='0'
						WHERE id_servico_campo='370';
--07/08/2013 16:24:03
UPDATE vsites_servico_campo SET campo='certidao_cidade_do_estrangeiro',tipo='text',nome='CIDADE DO ESTRANGEIRO',valor='',largura='470',mascara='',site='1',ordenacao='16',obrigatorio='0'
						WHERE id_servico_campo='204';
--07/08/2013 16:24:04
UPDATE vsites_servico_campo SET campo='certidao_provincia_regiao',tipo='text',nome='PROVINCIA REGIAO DO',valor='',largura='470',mascara='',site='1',ordenacao='17',obrigatorio='0'
						WHERE id_servico_campo='1035';
--07/08/2013 16:24:04
DELETE FROM vsites_servico_campo WHERE id_servico_campo = '' AND id_servico='78';
--20/08/2013 16:03:37
UPDATE vsites_servico SET dias='', status='Ativo', descricao='Autenticação Digital', site='',desc_site='',servico_desc='Autenticação Digital',site_menu='' WHERE id_servico='144';
--20/08/2013 16:03:38
INSERT INTO vsites_servico_campo (id_servico, campo, nome, tipo, largura, site, ordenacao) VALUES ('144','certidao_cidade','CIDADE','text','470','0','1');
--20/08/2013 16:03:38
INSERT INTO vsites_servico_campo (id_servico, campo, nome, tipo, largura, site, ordenacao) VALUES ('144','certidao_estado','ESTADO','text','470','0','2');
--20/08/2013 16:03:38
DELETE FROM vsites_servico_campo WHERE id_servico_campo = '' AND id_servico='144';