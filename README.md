# Soloäventyr - Hans och Greta

Projektarbete i Webbserverprogrammering 1, att skriva och koda ett soloäventyr baserat på operan Hans och Greta.

![Story image](https://raw.githubusercontent.com/jensnti/wsp1-soloaventyr/master/drawio-story.png)

## Databas

Kör mysql. Skapa databasen själv eller se exempel i repot.

    CREATE DATABASE databasnamn CHARACTER SET utf8mb4;
    USE databasnamn;

**Table för berättelsen.**

Vi klarar oss bra med en text och ett id för att kunna identifiera raden.

    +-------+------------------+------+-----+---------+----------------+
    | Field | Type             | Null | Key | Default | Extra          |
    +-------+------------------+------+-----+---------+----------------+
    | id    | int(10) unsigned | NO   | PRI | NULL    | auto_increment |
    | body  | text             | NO   |     | NULL    |                |
    +-------+------------------+------+-----+---------+----------------+

    CREATE TABLE story (id INT UNSIGNED AUTO_INCREMENT, PRIMARY KEY(id)) ENGINE = innodb DEFAULT CHARACTER SET = utf8mb4;
    ALTER TABLE story ADD body TEXT NOT NULL;

**Table för att länka berättelsen.**

Länktabellen kommer att koppla ihop det aktuella textavsnittet (story_id) med spelarens val (target_id). Vi gör dessa två fält till index för att kunna koppla ihop dem med id ur story, men även för att snabba upp sökningar.

    +-------------+------------------+------+-----+---------+----------------+
    | Field       | Type             | Null | Key | Default | Extra          |
    +-------------+------------------+------+-----+---------+----------------+
    | id          | int(10) unsigned | NO   | PRI | NULL    | auto_increment |
    | story_id    | int(10) unsigned | NO   | MUL | NULL    |                |
    | target_id   | int(10) unsigned | NO   | MUL | NULL    |                |
    | description | varchar(255)     | NO   |     | NULL    |                |
    +-------------+------------------+------+-----+---------+----------------+

    CREATE TABLE links (id INT UNSIGNED AUTO_INCREMENT, PRIMARY KEY(id)) ENGINE = innodb DEFAULT CHARACTER SET = utf8mb4;
    ALTER TABLE links ADD story_id INT UNSIGNED NOT NULL;
    ALTER TABLE links ADD target_id INT UNSIGNED NOT NULL;
    ALTER TABLE links ADD description VARCHAR(255) NOT NULL;
    CREATE INDEX story_id ON links (story_id);
    CREATE INDEX target_id ON links (target_id);

## PHP Grund

Vi kommer att utveckla och skapa koden för detta tillsammans. Du kan klona/forka detta repo för att få en grund att utgå ifrån om du så vill.
Viktigt att vi skapar en .gitignore i rooten för att inte ladda upp vår dbinfo.php

**Filstruktur**

    php/
        css/
            style.css
        img/
        js/
        views/
            index.php
        include/
            dbinfo_example.php
            dbinfo.php
            db.php
        index.php

I index.php så startar vi i dagsläget vår story, detta kan med fördel bytas ut mot en "splash-screen" med spelets logga och eventuella regler.
Studera koden i index.php, notera att vi behöver två olika frågor för att dels välja storyn menn även dess tillhörande länkar.

    SELECT * FROM story WHERE id = x;

Vi väljer alla fält från den story vi specifierar, på första sidan blir det såklart berättelsens start, men vi kommer senare behöva  byta ut detta till vars i berättelsen vi befinner oss. Dvs. en variabel som vi kommer att läsa in från GET.
Denna data är en rad från databasen så vi kör fetch från php.

Länkarna väljer vi utifrån vilken story sida vi är på.

    SELECT * FROM links WHERE story_id = x;

Länk-datan kommer att vara en eller flera rader så vi kör fetchall i php, därför är det viktigt att vi behandlar den utifrån det (loopa).

Vi använder sen detta för att skapa vår view för index där vi skriver ut både story och links.

## Extra

### Database

![Database image](https://raw.githubusercontent.com/jensnti/wsp1-soloaventyr/master/databas.png)

Om du vill vidareutveckla spelet och utöka funktionerna så kan du skapa ytterligare tabeller för detta. Ett tips är att kolla
på Ensamma vargen spelen och hitta inspiration i dessa. Här är starten på ett antal tabeller och ideer.

    +----------------+------------------+------+-----+---------+----------------+
    | Field          | Type             | Null | Key | Default | Extra          |
    +----------------+------------------+------+-----+---------+----------------+
    | id             | int(10) unsigned | NO   | PRI | NULL    | auto_increment |
    | name           | varchar(64)      | NO   |     | NULL    |                |
    | endurance      | int(11)          | NO   |     | 20      |                |
    | primary_hand   | int(10) unsigned | NO   | MUL | NULL    |                |
    | secondary_hand | int(10) unsigned | NO   | MUL | NULL    |                |
    | backpack_size  | int(10) unsigned | NO   |     | 10      |                |
    +----------------+------------------+------+-----+---------+----------------+

    CREATE TABLE players (id INT UNSIGNED AUTO_INCREMENT, PRIMARY KEY(id)) ENGINE = innodb DEFAULT CHARACTER SET = utf8mb4;
    ALTER TABLE players ADD name VARCHAR(64) NOT NULL;
    ALTER TABLE players ADD endurance INT NOT NULL DEFAULT 20;
    ...

    +-------------+------------------+------+-----+---------+----------------+
    | Field       | Type             | Null | Key | Default | Extra          |
    +-------------+------------------+------+-----+---------+----------------+
    | id          | int(10) unsigned | NO   | PRI | NULL    | auto_increment |
    | name        | varchar(64)      | NO   |     | NULL    |                |
    | size        | int(10) unsigned | YES  |     | NULL    |                |
    | description | text             | YES  |     | NULL    |                |
    +-------------+------------------+------+-----+---------+----------------+

    CREATE TABLE items (id INT UNSIGNED AUTO_INCREMENT, PRIMARY KEY(id)) ENGINE = innodb DEFAULT CHARACTER SET = utf8mb4;
    ALTER TABLE items ADD name VARCHAR(64) NOT NULL;
    ALTER TABLE items ADD size INT UNSIGNED;
    ALTER TABLE items ADD description TEXT;

    +---------+------------------+------+-----+---------+----------------+
    | Field   | Type             | Null | Key | Default | Extra          |
    +---------+------------------+------+-----+---------+----------------+
    | id      | int(10) unsigned | NO   | PRI | NULL    | auto_increment |
    | item_id | int(10) unsigned | NO   | MUL | NULL    |                |
    | user_id | int(10) unsigned | NO   | MUL | NULL    |                |
    +---------+------------------+------+-----+---------+----------------+

    CREATE TABLE backpacks (id INT UNSIGNED AUTO_INCREMENT, PRIMARY KEY(id)) ENGINE = innodb DEFAULT CHARACTER SET = utf8mb4;
    ALTER TABLE backpacks ADD item_id INT UNSIGNED NOT NULL;
    ALTER TABLE backpacks ADD user_id INT UNSIGNED NOT NULL;# wsp1-soloadventure
