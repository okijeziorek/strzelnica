# Instalacja i uruchomienie

## Wymagania

- najnowszy stabilny WordPress, bazowo 7.0;
- PHP 8.2 lub nowszy;
- MySQL/MariaDB zgodne z używaną wersją WordPressa;
- uprawnienia administratora.

## WordPress Playground

1. Otwórz link `Uruchom stronę w WordPress Playground` z README.
2. Blueprint instaluje najnowszy WordPress i PHP 8.3, loguje jako administrator oraz aktywuje motyw z `main`.
3. Po uruchomieniu otwórz `Strony → Strona główna`, aby edytować bloki.
4. Nagłówek i menu znajdziesz w `Wygląd → Edytor`.

Do testowania niezmergowanej gałęzi zmień `ref` w kopii `blueprint.json` na nazwę tej gałęzi i udostępnij surowy plik przez GitHub.

## Instalacja ZIP

1. Pobierz artefakt `gun-resort-one` z udanego workflow GitHub Actions albo zbuduj archiwum poleceniem:

```bash
git archive --format=zip --prefix=gun-resort-one/ --output=gun-resort-one.zip HEAD
```

2. W WordPressie przejdź do `Wygląd → Motywy → Dodaj nowy → Wyślij motyw`.
3. Wskaż `gun-resort-one.zip`, zainstaluj i aktywuj.
4. Odśwież panel. Po migracji pojawi się komunikat z linkiem do strony głównej.

## Instalacja z repozytorium

```bash
git clone https://github.com/okijeziorek/strzelnica.git gun-resort-one
```

Umieść katalog w `wp-content/themes/` i aktywuj motyw.

## Kontrola po instalacji

- otwórz stronę główną bez logowania;
- sprawdź menu na komputerze i telefonie;
- przesuń jeden kafelek, zapisz i odśwież stronę;
- sprawdź przycisk zewnętrznej rezerwacji, jeśli został dodany;
- sprawdź zwykłą stronę, wpis i 404;
- sprawdź brak błędów PHP i konsoli przeglądarki.

## Rollback z 2.0

1. Wykonaj kopię bazy i plików.
2. Wgraj poprzednie wydanie motywu.
3. Odczytaj `gro_block_migration_backup` i przywróć zapisane wartości strony startowej albo wybierz starą stronę w `Ustawienia → Czytanie`.

Migrator nie usuwa starych stron, wpisów ani ustawień Customizera.
