
/**
* Alteração nos campos title e subtitle da tabela posts 
* para implementar o recurso de busca de posts do blog
* Busca utilizando a consulta "MATCH AGAINST"
* Referente ao commit: 10.02 - Registro inicial e FULLTEXT - f9044fa09291018e439d0a31b05a4d146f210724
*/ 
ALTER TABLE posts
ADD FULLTEXT(title,subtitle);