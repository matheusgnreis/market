#### Definindo admin_settings de um aplicativo

Disponibilizamos em todos os aplicativos duas propriedades que ajudam o seu aplicativo a funcionar conforme esperado.

As propriedades são data e hidden_data. A propriedade data é pública, e é exibida nas requisições não auteticadas. Use para salvar dados e preferências do usuário que possam ser expostas. Já a propriedade hidden_data é privada e só é exibida em requisições auteticadas. Use essa propriedade para salva em seu aplicativo dados sensíveis como tokens, preferências ocultas e outras definições do usuário que possam ser acessados apenas com autenticação.

Para definir uma propriedade no data da sua aplicação, basta adicionar um novo campo de configuração, informar o nome para a propriedade, preencha seu schema e deixe o checkbox hide desmarcado. Para definir uma propriedade no hidden_data da sua aplicação, basta seguir os passos acima, marcando o checkbox hide.

Usamos json-schema para renderizar as configurações do seu aplicativo para o lojista, por isso, o schema da propriedade deve seguir as seguintes [especificações](http://json-schema.org/learn/getting-started-step-by-step.html) .
____
Abaixo temos exemplos de propriedades de diversos tipos;

Boolean
```json
{
  "schema": {
    "title": "Aviso de Recebimento",
    "type": "boolean",
    "default": true,
    "description": "Notificar ao destinatário quando seu pacote for recebido."
  }
}     
```

Interge
```json
{
  "schema": {
    "title": "Agência Jadlog",
    "type": "interge",
    "description": "Agência da transportadora jadlog que fará a coleta das encomendas"
  }
}
```
String
```json
{
  "schema": {
    "title": "Nome do serviço",
    "type": "string",
    "description": "Nome para o serviço",
  }
}
```
String com enum
```json
{
  "schema": {
    "title": "Ordem dos serviços",
    "type": "string",
    "description": "Para ordernar o resultado dos serviços do menor prazo de envio para o maior selecione `-delivery` caso contrário selecione a opção `delivery`. Se preferir ordernar o resultado do cálculo do frete do menor preço para maior use `-price`, do contrário selecione `price`.",
    "enum": [
      "-price",
      "price",
      "-delivery",
      "delivery"
    ]
  }
}
```
Objeto 
```json
{
  "schema": {
    "type": "object",
    "title": "Endereço do remetente das encomendas.",
    "required": [
      "zip",
      "street",
      "number"
    ],
    "properties": {
      "zip": {
        "title": "CEP",
        "type": "string",
        "maxLength": 30,
        "description": "ZIP (CEP, postal...) code"
      },
      "street": {
        "title": "Rua",
        "type": "string",
        "maxLength": 200,
        "description": "Nome da rua"
      },
      "number": {
        "title": "Número",
        "type": "integer",
        "min": 1,
        "max": 9999999,
        "description": "Número"
      }
    }
  }
}
  ```
  Array
  ```json
  {
  "schema": {
    "type": "array",
    "title": "Desativar serviços",
    "description": "É possível desabilitar determinados serviços de envio para determinadas faixas de cep ou para todo o Brasil.",
    "items": {
      "type": "object",
      "required": [
        "states",
        "services"
      ],
      "properties": {
        "states": {
          "type": "array",
          "title": "Faixa de Cep",
          "description": "Faixa de códigos postais para qual serão desabalitados os serviços.",
          "items": {
            "type": "object",
            "required": [
              "from",
              "to"
            ],
            "properties": {
              "from": {
                "type": "string",
                "title": "Cep inicial",
                "description": "Cep inicial para desabilitar determinado serviço de envio - ex: 31920-310"
              },
              "to": {
                "type": "string",
                "title": "Cep final",
                "description": "Cep final para desabilitar determinado serviço de envio - ex: 31920-310"
              }
            }
          }
        },
        "services": {
          "type": "array",
          "title": "Serviços",
          "description": "Serviços que podem ser desabilitados",
          "items": {
            "type": "string",
            "description": "Caso algum serviço seja selecionado e nenhuma faixa de cep seja informada, o serviço estará indisponível para todo Brasil.",
            "title": "Opções",
            "enum": [
              "PAC",
              ".Package",
              "EXPRESSO",
              ".Com"
            ]
          }
        }
      }
    }
  }
}
```