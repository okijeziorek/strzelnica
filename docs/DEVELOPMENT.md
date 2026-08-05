# Rozwój i testowanie

## Środowisko lokalne

Do pracy można użyć dowolnego lokalnego środowiska WordPress, przykładowo kontenerów Docker, Local, XAMPP albo natywnego stosu Apache/Nginx, PHP i MariaDB.

Zalecane jest osobne środowisko:

- deweloperskie;
- testowe;
- produkcyjne.

Nie należy rozwijać motywu bezpośrednio na stronie publicznej.

## Pobranie repozytorium

```bash
git clone https://github.com/okijeziorek/strzelnica.git
cd strzelnica
```

Następnie utwórz gałąź roboczą:

```bash
git switch main
git pull --ff-only
git switch -c feature/nazwa-zmiany
```

## Podłączenie do WordPressa

Najwygodniej umieścić repozytorium bezpośrednio w katalogu motywów albo utworzyć dowiązanie symboliczne:

```bash
ln -s /ścieżka/do/strzelnica /ścieżka/do/wordpress/wp-content/themes/gun-resort-one
```

Na Windowsie można użyć odpowiedniego polecenia `mklink` uruchomionego z wymaganymi uprawnieniami.

## Standard zmian

Każda zmiana powinna:

- mieć jasno określony zakres;
- nie wprowadzać treści biznesowych na sztywno;
- zachowywać escapowanie wyjścia;
- sanitizować i walidować dane wejściowe;
- działać bez błędów JavaScriptu;
- zachowywać obsługę klawiatury;
- nie psuć widoku mobilnego;
- posiadać aktualizację dokumentacji, gdy zmienia konfigurację lub zachowanie.

## Kontrola składni PHP

Dla każdego pliku PHP:

```bash
php -l functions.php
php -l dynamic.php
php -l front-page.php
php -l header.php
php -l footer.php
```

Można sprawdzić wszystkie pliki:

```bash
find . -name '*.php' -print0 | xargs -0 -n1 php -l
```

## WordPress Coding Standards

Zalecane narzędzia:

```bash
composer require --dev squizlabs/php_codesniffer wp-coding-standards/wpcs
```

Następnie skonfiguruj ścieżki standardów i uruchamiaj PHPCS. Docelowo repozytorium powinno zawierać własny `phpcs.xml.dist`.

## Testy ręczne

### Strona główna

- strona ładuje się bez ostrzeżeń PHP;
- wszystkie sekcje wyświetlają wpisy z panelu;
- puste sekcje nie tworzą uszkodzonego układu;
- obrazy mają poprawne proporcje;
- kolejność wpisów jest zgodna z `menu_order`.

### Menu

- menu otwiera się na telefonie;
- przycisk aktualizuje `aria-expanded`;
- klawisz Escape zamyka menu;
- kliknięcie poza menu zamyka menu;
- fokus wraca do przycisku po zamknięciu klawiaturą;
- odnośniki prowadzą do istniejących sekcji.

### Formularz

Ta sekcja dotyczy usuniętej implementacji. W aktualnym motywie należy zamiast niej sprawdzić widoczność przycisku oraz poprawność odnośnika HTTPS do zewnętrznego operatora rezerwacji.

Sprawdź przypadki:

- poprawny e-mail;
- poprawny numer telefonu;
- błędny kontakt;
- brak usługi;
- podrobiona usługa niewystępująca w panelu;
- data przeszła;
- data ponad dwa lata naprzód;
- błędna godzina;
- wiadomość przekraczająca limit;
- błędny nonce;
- wypełniony honeypot;
- awaria wysyłki poczty;
- poprawna wysyłka.

### Responsywność

Minimalny zestaw szerokości:

```text
320 px
375 px
768 px
1024 px
1440 px
```

Sprawdź również powiększenie przeglądarki do 200%.

### Dostępność

- przejście całej strony samą klawiaturą;
- widoczny fokus;
- poprawna hierarchia nagłówków;
- dostępne nazwy przycisków;
- komunikaty formularza odczytywane przez `aria-live`;
- wystarczający kontrast;
- brak informacji przekazywanych wyłącznie kolorem;
- zachowanie przy `prefers-reduced-motion`.

## Debugowanie WordPressa

W środowisku lokalnym można ustawić:

```php
define('WP_DEBUG', true);
define('WP_DEBUG_LOG', true);
define('WP_DEBUG_DISPLAY', false);
```

Log znajduje się zwykle w `wp-content/debug.log`. Nie należy włączać publicznego wyświetlania błędów na produkcji.

## Commity

Commity powinny być małe i opisywać jedną logiczną zmianę. Przykłady:

```text
Dodaj walidację godzin otwarcia
Przenieś typy wpisów do wtyczki
Popraw obsługę pustej listy usług
Dodaj dokumentację SMTP
```

## Pull request

Opis PR powinien zawierać:

- cel zmiany;
- zakres zmienionych plików;
- wpływ na administratora i użytkownika;
- instrukcję testowania;
- zrzuty ekranu dla zmian wyglądu;
- informacje o migracji danych;
- znane ograniczenia.

## Wersjonowanie

Zalecane jest wersjonowanie semantyczne:

```text
MAJOR.MINOR.PATCH
```

- `MAJOR` — zmiana niezgodna wstecz;
- `MINOR` — nowa zgodna funkcja;
- `PATCH` — poprawka błędu.

Numer w `style.css`, changelog i oznaczenie wydania powinny być zgodne.

## Przed wydaniem

1. zaktualizuj wersję;
2. zaktualizuj changelog;
3. sprawdź składnię PHP;
4. uruchom standardy kodowania;
5. wykonaj pełne testy formularza;
6. sprawdź widoki mobilne;
7. sprawdź stronę bez zalogowania;
8. sprawdź instalację ze świeżego ZIP-a;
9. usuń pliki robocze i dane testowe;
10. przygotuj kopię zapasową wdrożenia.

## Zalecana przyszła automatyzacja

Repozytorium powinno docelowo otrzymać GitHub Actions wykonujące:

- `php -l`;
- PHPCS dla WordPress Coding Standards;
- kontrolę plików JSON;
- podstawowe testy JavaScriptu;
- budowę archiwum ZIP;
- publikację artefaktu testowego.
