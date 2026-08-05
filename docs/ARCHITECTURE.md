# Architektura

Gun Resort One jest natywnym motywem blokowym. WordPress renderuje szablony HTML, a treści strony głównej są zwykłymi blokami zapisanymi w `post_content`.

## Warstwy

- `templates/` — szablony strony głównej, stron, wpisów, listy i 404;
- `parts/` — edytowalne części nagłówka i stopki;
- `patterns/` — niesynchronizowane wzorce hero oraz kafelków;
- `theme.json` — paleta, typografia, odstępy i ustawienia edytora;
- `main.css` — responsywne style charakterystyczne dla makiety;
- `inc/legacy-migration.php` — jednorazowa migracja wersji 1.x.

Nie ma własnych bloków React ani procesu kompilacji JavaScript. Układ korzysta z bloków rdzenia WordPressa.

## Renderowanie strony głównej

1. WordPress wybiera `templates/front-page.html`.
2. Szablon wstawia część `header` i blok `Post Content`.
3. Hero i kafelki są odczytywane z treści statycznej strony głównej.
4. Style pochodzą z `theme.json` i `main.css`.
5. Zapis w edytorze blokowym aktualizuje standardową treść strony lub część szablonu.

## Migracja

Migrator pozostawia stare `theme_mods` i wpisy `gro_feature`, `gro_card`, `gro_price` w bazie. Typy są przez jeden cykl wydania rejestrowane bez interfejsu administracyjnego, wyłącznie aby migracja i rollback mogły odczytać dane.

Nowa strona powstaje jako szkic. Migrator tworzy również `wp_navigation` oraz bazodanowy wariant `wp_template_part` dla nagłówka. Dopiero gdy wszystkie obiekty zapiszą się poprawnie, publikuje stronę i ustawia `show_on_front=page` oraz `page_on_front`.

Wewnętrzna domena rezerwacji, formularz, e-mail i typ usług nie należą do motywu. Zewnętrzna rezerwacja jest wyłącznie odnośnikiem w bloku Button.
