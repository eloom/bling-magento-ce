# Bling NFe para Magento

## Recursos


## Perguntas Frequentes


## Dependências


O módulo do Bling ERP para Magento precisa do módulo [Bootstrap para Magento CE](https://github.com/eloom/bootstrap-magento-ce)


## Compatibilidade

- [x] Magento 1.9.3.x

- [x] PHP/PHP-FPM 5.6

## Começando

Os projetos da élOOm utilizam o [Apache Ant](https://ant.apache.org/) para publicar o projeto nos ambientes de **desenvolvimento** e de **teste** e para gerar os pacotes para o **ambiente de produção**.

- Publicando no **ambiente local**

	- no arquivo **build-desenv.properties**, informe o path do **Document Root** na propriedade "projetos.path";
	
	- na raiz deste projeto, execute, no prompt, o comando ```ant -f build-desenv.xml```.
	
	
	> a tarefa Ant irá copiar todos os arquivos do projeto no seu Magento e limpar a cache.
	

- Publicando para o **ambiente de produção**

	- na raiz deste projeto, execute, no prompt, o comando ```ant -f build-producao.xml```.
	
	
	> a tarefa Ant irá gerar um pacote no formato .zip, no caminho definido na propriedade "projetos.path", do arquivo **build-producao.properties**.

	> os arquivos .css e .js serão comprimidos automáticamente usando o [YUI Compressor](https://yui.github.io/yuicompressor/).
	

## Release Notes

### [1.0.0] - 2018-10-03

#### Versão inicial

### [1.0.1] - 2018-11-09

#### Added

- integração com Intermediador de Pagamento PayU

### [1.0.2] - 2019-07-14

#### Added

- integração com Intermediador de Pagamento Yapay