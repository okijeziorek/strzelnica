# Model treści

## Aktywny model 2.0

| Treść | Miejsce edycji | Reprezentacja |
|---|---|---|
| Hero i kafelki | `Strony → Strona główna` | bloki w `post_content` |
| Logo i nazwa | `Wygląd → Edytor` | Site Logo i Site Title |
| Menu | `Wygląd → Edytor → Nawigacja` | `wp_navigation` |
| Górny pasek | edycja części nagłówka | bloki Paragraph i Group |
| Link rezerwacji | strona lub nagłówek | blok Button |
| Style globalne | `Wygląd → Edytor → Style` | `theme.json` i ustawienia użytkownika |

Wzorce motywu są niesynchronizowane. Po wstawieniu ich elementy należą do strony i mogą być dowolnie przesuwane, usuwane lub zmieniane.

## Dane migrowane z 1.x

- `gro_hero_title`, `gro_hero_text`, obraz hero i przycisk oferty;
- opcjonalny zewnętrzny przycisk rezerwacji;
- opublikowane wpisy `gro_feature`, ich kolejność i obrazy wyróżniające;
- menu przypisane do historycznej lokalizacji `primary`;
- telefon, komunikat i godziny z górnego paska.

Jeśli brakuje starego menu, powstają odnośniki Start, Oferta i Pakiety. Jeśli brakuje zalet, motyw tworzy cztery domyślne kafelki bez tworzenia nowych wpisów CPT.

## Bezpieczeństwo migracji

- nowa strona powstaje obok starej;
- przełączenie strony głównej jest ostatnim krokiem;
- stara strona i stare dane nie są usuwane;
- przerwana migracja wykorzystuje oznaczone obiekty zamiast tworzyć duplikaty;
- po sukcesie opcja `gro_block_migration_version` zapobiega ponownemu wykonaniu;
- poprzednie wartości `show_on_front` i `page_on_front` są zapisywane w `gro_block_migration_backup`.

Obrazy redakcyjne powinny trafiać do biblioteki mediów, mieć tekst alternatywny i potwierdzone prawa do publikacji.
