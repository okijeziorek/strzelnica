# Gun Resort One

[Uruchom stronę w WordPress Playground](https://playground.wordpress.net/?blueprint-url=https%3A%2F%2Fraw.githubusercontent.com%2Fokijeziorek%2Fstrzelnica%2Fmain%2Fblueprint.json)

Gun Resort One 2.0 to motyw blokowy WordPressa. Stronę można układać bez kodowania w `Wygląd → Edytor`, a treść strony głównej także przez `Strony → Strona główna`.

## Najważniejsze cechy

- edytowalny nagłówek, menu, hero i cztery kafelki;
- pełna swoboda przesuwania, usuwania, duplikowania i zmiany kolumn;
- wzorce `Hero Gun Resort` oraz `Cztery kafelki Gun Resort`;
- automatyczna, jednorazowa migracja danych z wersji 1.x;
- opcjonalny przycisk prowadzący do zewnętrznego operatora rezerwacji;
- brak lokalnego formularza i przechowywania danych rezerwacji;
- responsywny układ i nawigacja mobilna oparta na bloku WordPressa;
- automatyczne kontrole PHP, WordPress Coding Standards, JSON i artefakt ZIP w GitHub Actions.

## Wymagania

- najnowszy stabilny WordPress (bazowo 7.0);
- PHP 8.2 lub nowszy;
- uprawnienia administratora WordPressa.

## Uruchomienie

1. Otwórz link WordPress Playground powyżej albo zainstaluj repozytorium jako katalog `wp-content/themes/gun-resort-one`.
2. Aktywuj motyw **Gun Resort One**.
3. Po pierwszym zalogowanym uruchomieniu motyw utworzy blokową stronę główną i pokaże link do jej edycji.
4. Wejdź w `Wygląd → Edytor`, aby edytować nagłówek, menu, style i szablony.
5. Wejdź w `Strony → Strona główna`, aby przesuwać hero, kafelki i przyciski.

Pełna instrukcja: [docs/INSTALLATION.md](docs/INSTALLATION.md).

## Migracja z wersji 1.x

Migrator odczytuje dotychczasowe ustawienia hero, cztery zalety, przypisane menu i informacje górnego paska. Tworzy nową stronę i edytowalny nagłówek, a dopiero potem przełącza stronę startową. Stara strona, wpisy i ustawienia Customizera pozostają w bazie jako kopia do rollbacku.

Migracja jest oznaczana opcją `gro_block_migration_version` i nie uruchamia się ponownie po sukcesie. Szczegóły: [docs/CONTENT-MODEL.md](docs/CONTENT-MODEL.md).

## Rezerwacje

Motyw nie wysyła i nie przechowuje rezerwacji. Link do zewnętrznego operatora jest zwykłym blokiem Button: można go edytować, przesunąć albo usunąć razem z pozostałą treścią.

## Rozwój

Instalacja narzędzi i testy:

```bash
composer install
composer lint
```

GitHub Actions dodatkowo sprawdza składnię PHP i JSON oraz buduje instalowalne archiwum `gun-resort-one.zip`. Zasady współpracy przez GitHub i Slack opisano w [docs/DEVELOPMENT.md](docs/DEVELOPMENT.md).

## Licencja

Kod motywu: GNU GPL v2 lub nowsza. Przed publikacją należy osobno potwierdzić prawa do zdjęć i pozostałych materiałów.
