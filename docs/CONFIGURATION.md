# Konfiguracja motywu

## Edycja strony głównej

Panel `Wygląd → Dostosuj → Strona główna — treść` pozwala edytować górny pasek, sekcję główną, zdjęcie, teksty i adresy przycisków oraz włączać menu i przycisk rezerwacji. Nazwę strony i logo ustawia się w `Wygląd → Dostosuj → Tożsamość witryny`.

Cztery kafelki są wpisami w sekcji `Zalety`. Każdy kafelek ma edytowalny tytuł, opis, obrazek wyróżniający i kolejność. Można również dodawać nowe kafelki, usuwać istniejące lub zapisywać je jako szkice, aby ukryć je na stronie.

## Ustawienia ogólne WordPressa

Nazwa marki pobierana jest z tytułu witryny, a logo z mechanizmu własnego logo WordPressa. Ustaw je w `Ustawienia → Ogólne` oraz `Wygląd → Dostosuj → Tożsamość witryny`.

## Sekcja „Strona główna — treść”

Pola zarejestrowane przez motyw znajdują się w `Wygląd → Dostosuj → Strona główna — treść`.

### Sekcja główna

- `Nagłówek główny` — główny nagłówek strony;
- `Opis główny` — tekst pod nagłówkiem;
- `Przycisk oferty` — etykieta przycisku prowadzącego do oferty;
- `Przycisk rezerwacji` — etykieta przycisku prowadzącego do formularza;
- `Zdjęcie główne` — obraz tła sekcji otwierającej.

### Nagłówki sekcji

- `Etykieta sekcji zalet` — nazwa dostępnościowa sekcji zalet;
- `Nagłówek cennika` — tytuł nad listą cen;
- `Nagłówek formularza` — tytuł formularza.

### Formularz

- `Pole wyboru usługi`;
- `Pole imienia i nazwiska`;
- `Pole telefonu lub e-maila`;
- `Pole wiadomości`;
- `Przycisk wysłania`;
- `Notatka formularza`;
- `Komunikat sukcesu`;
- `Komunikat błędu`;
- `Wysyłanie formularza`.

Teksty te odpowiadają za etykiety, podpowiedzi i komunikaty interfejsu. Należy stosować jednoznaczne sformułowania, zwłaszcza w formularzu.

### Menu mobilne

- `Otwórz menu`;
- `Zamknij menu`.

Wartości przekazywane są do JavaScriptu przez `wp_localize_script()`.

### Dane kontaktowe

- `Telefon` — wyświetlany i używany w odnośniku `tel:`;
- `E-mail kontaktowy` — publiczny adres kontaktowy;
- `E-mail odbiorcy rezerwacji` — adres, na który trafiają zgłoszenia;
- `Adres` — adres obiektu;
- `Godziny otwarcia` — tekst informacyjny;
- `Tekst górnego paska` — krótki komunikat w nagłówku;
- `Opis w stopce` — opis działalności.

Adres odbiorcy rezerwacji musi być prawidłowym adresem e-mail. Gdy pole jest puste albo niepoprawne, formularz nie wyśle wiadomości.

### Odnośniki

- `Mapa`;
- `Regulamin`;
- `Cookies`;
- `Facebook`;
- `X`;
- `Instagram`.

Adresy są sanitizowane przez `esc_url_raw`. Należy wprowadzać pełne adresy zawierające protokół, przykładowo `https://`.

## Własne typy wpisów

### Zalety (`gro_feature`)

Obsługiwane pola:

- tytuł;
- treść;
- obraz wyróżniający;
- kolejność.

### Karty oferty (`gro_card`)

Obsługiwane pola:

- tytuł;
- treść;
- zajawka;
- obraz wyróżniający;
- kolejność.

### Usługi (`gro_service`)

Obsługiwane pola:

- tytuł;
- treść;
- kolejność.

Tytuł jest wartością wysyłaną przez formularz. Zmiana tytułu zmienia więc także nazwę usługi w zgłoszeniach.

### Cennik (`gro_price`)

Obsługiwane pola:

- tytuł — nazwa pozycji;
- zajawka — cena albo komunikat;
- kolejność.

## Kolejność wyświetlania

Elementy są pobierane według:

1. pola `menu_order` rosnąco;
2. daty publikacji rosnąco.

Pole kolejności jest dostępne dzięki obsłudze `page-attributes`. Warto stosować odstępy, przykładowo 10, 20, 30, aby łatwo wstawiać nowe elementy pomiędzy istniejące.

## Menu i odnośniki do sekcji

Sekcje strony używają identyfikatorów takich jak `oferta`, `pakiety`, `cennik`, `rezerwacja` i `kontakt`. Własne odnośniki menu mogą prowadzić do `/#identyfikator`.

Po zmianie identyfikatorów w kodzie należy zaktualizować menu, JavaScript obserwujący sekcje i wszystkie przyciski wewnętrzne.

## Zalecenia redakcyjne

- nie wpisuj danych osobowych pracowników bez podstawy prawnej;
- nie publikuj technicznych informacji o zabezpieczeniach obiektu;
- używaj krótkich tytułów kart;
- podawaj jasno, czy ceny są cenami końcowymi;
- aktualizuj regulamin i politykę prywatności;
- używaj obrazów z prawem do publikacji;
- uzupełniaj teksty alternatywne tam, gdzie mechanizm WordPressa je obsługuje.
