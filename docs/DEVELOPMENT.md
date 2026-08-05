# Rozwój, GitHub i Slack

## Praca lokalna

```bash
git clone https://github.com/okijeziorek/strzelnica.git
cd strzelnica
git switch main
git pull --ff-only
git switch -c codex/nazwa-zmiany
composer install
composer lint
```

Motyw nie wymaga Node.js ani kompilacji JavaScriptu. Zmiany należy sprawdzać na najnowszym stabilnym WordPressie i PHP 8.2+.

## GitHub

- GitHub issues są źródłem prawdy dla zakresu, decyzji i kryteriów odbioru.
- Jedno issue powinno opisywać jeden możliwy do odebrania rezultat.
- PR zawiera `Closes #…`, wpływ na administratora i użytkownika, kroki testowe, informacje o migracji oraz zrzuty desktop/mobile.
- PR zaczyna jako draft. Do merge’u wymagane są zielone kontrole i wynik testu z `#strzelnica-testy`.
- Gałęzie automatyzowane przez Codex używają prefiksu `codex/`.

Workflow `Quality` wykonuje:

- walidację Composer;
- kontrolę składni wszystkich plików PHP;
- WordPress Coding Standards;
- walidację JSON;
- budowę instalowalnego ZIP-a.

Theme Check należy wykonać na paczce ZIP w testowym WordPressie przed wydaniem produkcyjnym i zapisać wynik w issue odbiorowym.

## Slack

- `#propozycje` — decyzje produktowe i wygląd;
- `#strzelnica-dev` — linki do issues/PR-ów oraz status techniczny;
- `#strzelnica-testy` — Playground, scenariusze, błędy i odbiór;
- `#projekt-strzelnica` — krótkie podsumowania milestone’ów.

Zaakceptowaną decyzję ze Slacka należy skopiować do issue wraz z permalinkiem. Wiadomość na Slacku bez aktualizacji issue nie zmienia zakresu implementacji.

## Testy ręczne

Sprawdź szerokości 320, 375, 768, 1024 i 1440 px oraz powiększenie 200%.

- strona główna ma nagłówek, hero i cztery kafelki;
- wszystkie elementy można przesuwać, usuwać i duplikować;
- podmiana obrazu oraz zmiana kolumn zapisują się poprawnie;
- menu mobilne działa klawiaturą i ma widoczny fokus;
- link rezerwacji prowadzi do zewnętrznego HTTPS;
- brak formularza i lokalnego przetwarzania danych rezerwacji;
- migracja uruchamia się raz i nie tworzy duplikatów;
- stara strona i dane pozostają dostępne do rollbacku.

Przed wydaniem wykonaj także Theme Check, test świeżego ZIP-a, kontrolę konsoli i `WP_DEBUG_LOG`.
