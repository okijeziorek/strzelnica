# Model treści

## Aktywny model 2.4

| Treść | Miejsce edycji | Reprezentacja |
|---|---|---|
| Hero, zalety, pakiety i kroki | `Strony → Strona główna` | bloki w `post_content` |
| Logo | `Wygląd → Edytor` | blok Image lub Site Logo |
| Menu | `Wygląd → Edytor → Nawigacja` | `wp_navigation` |
| Górny pasek | edycja części nagłówka | bloki Paragraph i Group |
| Link rezerwacji | strona lub nagłówek | blok Button |
| Style globalne | `Wygląd → Edytor → Style` | `theme.json` i ustawienia użytkownika |

Wzorce motywu są niesynchronizowane. Po wstawieniu ich elementy należą do strony i mogą być dowolnie przesuwane, usuwane lub zmieniane.

Motyw nie rejestruje własnych bloków dynamicznych i nie renderuje widocznej treści z PHP. PHP służy wyłącznie do jednorazowego przepisania instalacji 1.x na natywne bloki. Po utworzeniu strony, menu i części szablonu ich zawartość w bazie WordPressa jest źródłem prawdy.

## Dane migrowane z 1.x

- `gro_hero_title`, `gro_hero_text`, obraz hero i przycisk oferty;
- opcjonalny zewnętrzny przycisk rezerwacji;
- opublikowane wpisy `gro_feature`, ich kolejność i obrazy wyróżniające;
- menu przypisane do historycznej lokalizacji `primary`;
- telefon, komunikat i godziny z górnego paska.

Jeśli brakuje starego menu, powstają odnośniki Start, Dlaczego my, Pakiety, Pierwszy raz i Kontakt. Jeśli brakuje zalet, motyw tworzy cztery domyślne kafelki bez tworzenia nowych wpisów CPT. Strony utworzone przed migracją 6 otrzymują jednorazowo brakujące sekcje. Późniejsze aktualizacje nie zmieniają treści strony, menu ani nagłówka.

## Bezpieczeństwo migracji

- nowa strona powstaje obok starej;
- przełączenie strony głównej jest ostatnim krokiem;
- stara strona i stare dane nie są usuwane;
- przerwana migracja wykorzystuje oznaczone obiekty zamiast tworzyć duplikaty;
- po sukcesie opcja `gro_block_migration_version` zapobiega ponownemu wykonaniu;
- istniejące obiekty migracji są zachowywane bez ponownego zapisu `post_content`;
- poprzednie wartości `show_on_front` i `page_on_front` są zapisywane w `gro_block_migration_backup`.

Obrazy redakcyjne powinny trafiać do biblioteki mediów, mieć tekst alternatywny i potwierdzone prawa do publikacji.
