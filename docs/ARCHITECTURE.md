# Architektura motywu

## Cel

Motyw rozdziela warstwę prezentacji od treści biznesowej. Szablony PHP odpowiadają za renderowanie i logikę integracyjną, natomiast treści pochodzą z bazy WordPressa.

## Główne warstwy

### 1. Warstwa konfiguracji

Plik `dynamic.php` rejestruje:

- własne typy wpisów;
- pola Personalizatora;
- ładowanie CSS i JavaScriptu;
- dane przekazywane do JavaScriptu;
- funkcje pomocnicze do pobierania treści.

Plik `functions.php` ładuje dynamiczną konfigurację oraz podstawowe mechanizmy motywu.

### 2. Warstwa danych

Dane są przechowywane w dwóch miejscach:

- opcje motywu przez `get_theme_mod()`;
- wpisy własnych typów przez `get_posts()`.

Typy wpisów:

```text
gro_feature  → zalety
gro_card     → karty oferty
gro_price    → pozycje cennika
```

### 3. Warstwa widoków

- `front-page.php` — strona główna;
- `header.php` — nagłówek, marka i menu;
- `footer.php` — dane kontaktowe, prawne i społecznościowe;
- `index.php` — ogólny widok listy treści;
- `page.php` — zwykłe strony;
- `single.php` — pojedyncze wpisy;
- `404.php` — strona błędu 404.

### 4. Warstwa prezentacji

- `main.css` — układ i wygląd komponentów;
- `style.css` — metadane motywu;
- `theme.json` — ustawienia edytora i funkcji WordPressa;
- `theme.js` — obsługa menu mobilnego.

## Przepływ renderowania strony głównej

1. WordPress wybiera `front-page.php`.
2. Szablon wywołuje funkcje pomocnicze z `dynamic.php`.
3. Ustawienia globalne są pobierane przez `get_theme_mod()`.
4. Elementy sekcji są pobierane przez `get_posts()`.
5. Dane są escapowane przed wyświetleniem.
6. CSS i JS są dołączane przez kolejkę WordPressa.
7. Teksty dla JavaScriptu są przekazywane przez `wp_localize_script()`.

## Historyczny przepływ formularza

Poniższy przepływ opisuje usuniętą implementację. Aktywny motyw kieruje użytkownika bezpośrednio do zewnętrznego operatora rezerwacji.

1. Formularz wysyła żądanie `POST` do `admin-post.php`.
2. Pole `action` wskazuje procedurę obsługi.
3. WordPress uruchamia akcję dla użytkownika zalogowanego albo niezalogowanego.
4. Backend sprawdza metodę żądania i nonce.
5. Backend sprawdza honeypot.
6. Dane są odwijane przez `wp_unslash()` i sanitizowane.
7. Usługa jest porównywana z opublikowanymi wpisami `gro_service`.
8. Data i godzina są walidowane.
9. Wiadomość jest budowana jako tekst zwykły.
10. `wp_mail()` podejmuje próbę wysyłki.
11. Użytkownik jest przekierowywany z parametrem statusu do sekcji formularza.

## Zasada braku treści na sztywno

W kodzie mogą pozostać:

- identyfikatory techniczne;
- nazwy hooków;
- nazwy typów wpisów;
- reguły walidacji;
- selektory CSS i JavaScript;
- struktura HTML;
- bezpieczne komunikaty awaryjne związane z błędami technicznymi.

W panelu powinny znajdować się:

- treści marketingowe;
- nazwy usług;
- ceny;
- dane kontaktowe;
- obrazy;
- etykiety przycisków i formularza;
- odnośniki prawne i społecznościowe.

## Ograniczenia obecnej architektury

- własne typy wpisów są rejestrowane w motywie, więc zmiana motywu ukryje ich interfejs administracyjny;
- formularz nie zapisuje danych w bazie;
- nie ma warstwy repozytorium ani osobnych klas domenowych;
- brak API REST przeznaczonego dla rezerwacji;
- brak systemu migracji ustawień;
- brak automatycznych testów;
- brak mechanizmu cache dla pobieranych wpisów;
- brak rate limitingu na poziomie aplikacji.

## Kierunek dalszej przebudowy

Dla rozwiązania produkcyjnego warto przenieść logikę domenową do osobnej wtyczki:

```text
wp-content/plugins/gun-resort-core/
```

Wtyczka powinna odpowiadać za:

- typy wpisów;
- rezerwacje;
- walidację i statusy;
- API;
- integrację z pocztą i płatnościami;
- zadania cykliczne;
- uprawnienia użytkowników.

Motyw powinien wówczas odpowiadać głównie za wygląd i renderowanie.
