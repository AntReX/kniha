# Aplikace: Správa knih
tato webová aplikace slouží pouze jako ukázka znalostí pro firmu u které se ucházím o místo programátora. Vytváření knihy bylo úmyslně provedeno klasickým odelsáním formuláře a samotné hledání pro ukázku bylo vytvořeno ajaxově. Pro vyhledávání jsem použil nejčastější praktiky a pro každou hodnotu jiný způsob.

# Přihlášení
 - jedná se pouze o primitivní přihlášení bez databáze
 - nastavení jména i hesla se provádí v /modely/Conf.php
# Vytvoření knihy
  - rok vydání je omezený na 4 čísla v opačném případě vrací chybu
  - autor je omezený na 50 znaků a vrací taktéž chybovou hlášku
  - název je omezený na 100 znaků taktéž vrací chyby
  - chyby se vrací všechny na jednou a nikoliv postupně.
  - probíhá kontrola, zda již stejná kniha existuje a v aopčném případě vyhodí chybovou hlášku
  - v případě chybové hlášky, tak zůstanou do doby refreshe vložené hodnoty stále vložené
  - v momentě úspěšného odeslání vyskočí informace o odeslání a zda knih není mnoho, tak lze vidět vložení ihned.
  - odeslání formuláře je klasickým způsobem

# Vyhledávání
- rok vydání se vyhledává klasickým způsobem, kdy rok se musí rovnat roku
- autora lze vyhledat i když obsahuje pouze nějakou část shodnou (LIKE)
- název knihy je fulltextově a musí se shodovat aspoň jedno slovo
- vyhledávání je úmyslně v tomto případě ajaxově a za pomocí jQuery dochází k úpravě DOM.
- jakmile nejsou zadané žádné údaje, tak se aplikuej defulatní načtení (100 záznamů)

# Nastavení
- veškeré nastavení se provádí v /modely/Conf.php
- mini nastavení pro zobrazování chybových hlášek SQL
- nastavení přístupu do databáze

# Smazání knihy
- vpravo každé knihy je tlačítko na smazání knihy z databáze
- každé smazání se musí potvrdit z důvodu nechtěného překliknutí 