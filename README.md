# Remington – Landing Page & System Rejestracji Zgłoszeń

Kompletna aplikacja webowa typu **Landing Page** z dynamicznym systemem zgłoszeń promocyjnych, panelem administracyjnym oraz zabezpieczonym API REST, zrealizowana w oparciu o framework **Laravel 8** i w pełni skonteneryzowana za pomocą narzędzia **Docker Compose**.

---

## Spis treści

- [O projekcie](#o-projekcie)
- [Główne moduły aplikacji](#główne-moduły-aplikacji)
- [Stos technologiczny](#stos-technologiczny)
- [Wymagania wstępne](#wymagania-wstępne)
- [Instalacja i pierwsze uruchomienie](#instalacja-i-pierwsze-uruchomienie)
- [Automatyzacja kontenera (entrypoint)](#automatyzacja-kontenera-entrypoint)
- [Dostępne usługi i porty](#dostępne-usługi-i-porty)
- [Domyślne dane dostępowe](#domyślne-dane-dostępowe)
- [Struktura projektu](#struktura-projektu)
- [API REST](#api-rest)
- [Przydatne polecenia dla programistów](#przydatne-polecenia-dla-programistów)
- [Uruchamianie testów](#uruchamianie-testów)

---

## O projekcie

Aplikacja została stworzona jako dedykowana strona promocyjna dla produktów marki **Remington** (m.in. seria *Hydraluxe*, *Hydraluxe PRO*). Umożliwia użytkownikom zapoznanie się z ofertą produktową, przejście do sklepów partnerskich oraz rejestrację zakupu w akcji promocyjnej poprzez rozbudowany formularz z dołączeniem dowodu zakupu (np. skanu paragonu lub faktury).

Dla administratorów przygotowano dedykowany panel zarządzania oraz zestaw endpointów REST API pozwalających na pełną kontrolę nad spływającymi zgłoszeniami, katalogiem produktów, listą sklepów i ankietą konsumencką.

---

## Główne moduły aplikacji

1. **Strona Główna (Frontend - Landing Page)**:
   - Prezentacja wyróżnionych produktów z opisami i parametrami.
   - Dynamiczne kafelki kierujące do ofert w popularnych sieciach handlowych (MediaMarkt, MediaExpert, RTV Euro AGD, Neonet).

2. **Formularz zgłoszeniowy (`/formularz`)**:
   - Rejestracja uczestnika promocji (dane osobowe, adresowe z wyborem województwa).
   - Wybór zakupionego produktu i podanie numeru seryjnego / daty zakupu.
   - Wskazanie sklepu (stacjonarny lub internetowy).
   - Ankieta konsumencka („Skąd wiesz o promocji?”).
   - Przesyłanie dowodu zakupu z walidacją plików po stronie klienta oraz serwera.
   - Ekran z podziękowaniem za przesłanie zgłoszenia (`/formularz/podziekowania`).

3. **Panel Administracyjny (`/panel`)**:
   - Dostęp chroniony uprawnieniami administratora (`Role::ADMIN`) oraz autoryzacją JWT.
   - **Zgłoszenia**: przegląd nadesłanych formularzy, szczegóły uczestnika, podgląd wgranych dowodów zakupu.
   - **Produkty**: zarządzanie bazą promowanych produktów (kody, nazwy, opisy).
   - **Sklepy**: lista i konfiguracja partnerów handlowych.
   - **Źródła wiedzy**: zarządzanie odpowiedziami w ankiecie „Skąd wiesz”.
   - **Linki partnerskie**: powiązania produktów z konkretnymi adresami URL w sklepach.

4. **Interfejs API REST (`/api/...`)**:
   - Zabezpieczony middlewarem kluczy API (`api.keys`) oraz autoryzacji (`api.auth`).
   - Pełne operacje CRUD dla wszystkich kluczowych encji systemu.

---

## Stos technologiczny

### Backend
- **PHP**: 8.0.3 (Apache)
- **Framework**: Laravel 8.x
- **Uwierzytelnianie**: Laravel Auth + JWT (`tymon/jwt-auth`)
- **Debugowanie**: Laravel Debugbar (w środowisku dev)

### Frontend
- **Szablony**: Blade (z podziałem na komponenty)
- **Framework CSS**: Bootstrap 4.6
- **Skrypty**: JavaScript (ES6+), jQuery 3.5.1
- **Preprocessor styli**: SCSS / Sass
- **Bundler assetów**: Laravel Mix 6 (Webpack), Node.js 14

### Baza danych i usługi pomocnicze
- **Baza danych**: MySQL 8.0
- **Narzędzie DB**: PhpMyAdmin 5.1
- **Serwer pocztowy (testowy)**: MailCatcher (przechwytuje maile w środowisku lokalnym)

### Infrastruktura
- **Konteneryzacja**: Docker (wieloetapowy build) & Docker Compose

---

## Wymagania wstępne

Przed uruchomieniem upewnij się, że na Twoim komputerze zainstalowane są:
- [Docker Engine](https://docs.docker.com/engine/install/) (wersja 20.10 lub nowsza)
- [Docker Compose](https://docs.docker.com/compose/) (zalecana wersja Compose v2)
- Narzędzie `git` do pobrania repozytorium

---

## Instalacja i pierwsze uruchomienie

### Krok 1: Sklonowanie repozytorium
```bash
git clone <adres-repozytorium>
cd hello-world-remington.pl
```

### Krok 2: Przygotowanie pliku konfiguracyjnego `.env`
Skopiuj przykładowy plik konfiguracyjny do `.env`:
```bash
cp .env.example .env
```

W pliku `.env` możesz dostosować parametry środowiska, m.in. porty kontenerów czy poświadczenia bazy danych (domyślna konfiguracja jest gotowa do natychmiastowego startu).

### Krok 3: Zbudowanie i uruchomienie kontenerów
Uruchom kontenery w tle z automatycznym procesem budowania obrazu:
```bash
docker compose up -d --build
```

*(Jeśli korzystasz ze starszej wersji Docker Compose v1, użyj polecenia `docker-compose up -d --build`)*

---

## Automatyzacja kontenera (entrypoint)

Podczas pierwszego uruchomienia kontenera `httpd`, skrypt startowy `docker/php/entrypoint.sh` wykonuje automatycznie całą procedurę przygotowawczą:

1. Nadaje odpowiednie uprawnienia katalogom `public/` oraz `storage/` (`www-data:www-data`, chmod 777).
2. Pobiera i instaluje pakiety PHP (`composer install --no-interaction --no-progress`).
3. Instaluje zależności Node.js oraz buduje assety CSS/JS (`npm install && npm run build`).
4. Generuje klucz szyfrujący aplikacji (`php artisan key:generate`).
5. Uruchamia migracje bazy danych wraz z seederami danych startowych (`php artisan migrate:fresh --seed`).
6. Czyści pamięć podręczną konfiguracji, tras i widoków (`cache:clear`, `config:clear`, `route:clear`).
7. Generuje sekret autoryzacji JWT (`php artisan jwt:secret`).
8. Tworzy dowiązanie symboliczne dla plików publicznych (`public/storage` -> `storage/app/public`).
9. Uruchamia serwer Apache w trybie pierwszoplanowym.

---

## Dostępne usługi i porty

Domyślne mapowanie portów zdefiniowane w pliku `.env.example`:

| Usługa | Opis | Domyślny adres URL | Zmienna środowiskowa |
| :--- | :--- | :--- | :--- |
| **Aplikacja WWW** | Serwer Apache + PHP 8.0 (Landing & Panel) | [http://localhost:8140](http://localhost:8140) | `DOCKER_HTTPD_PORT` |
| **PhpMyAdmin** | Narzędzie graficzne do bazy danych MySQL | [http://localhost:8142](http://localhost:8142) | `DOCKER_PHPMYADMIN_PORT` |
| **MailCatcher (Web)** | Podgląd wysłanych wiadomości e-mail w przeglądarce | [http://localhost:8148](http://localhost:8148) | `DOCKER_MAILCATCHER_WEB` |
| **MailCatcher (SMTP)**| Lokalny serwer pocztowy SMTP | `localhost:8147` | `DOCKER_MAILCATCHER_SMTP` |
| **Baza danych MySQL** | Bezpośredni dostęp do serwera MySQL | `localhost:8141` | `DOCKER_MYSQL_PORT` |

---

## Domyślne dane dostępowe

Po wykonaniu automatycznych seederów (`DatabaseSeeder`), w systemie dostępne są następujące konta:

### 1. Panel Administracyjny
- **Adres logowania**: [http://localhost:8140/login](http://localhost:8140/login)
- **Adres panelu**: [http://localhost:8140/panel](http://localhost:8140/panel)
- **Login (E-mail)**: `admin@example.com`
- **Hasło**: `asd123`
- **Rola**: Administrator (`UserRole::ADMIN`)

### 2. Baza danych MySQL
- **Host (z zewnątrz)**: `127.0.0.1` (lub `localhost`)
- **Port (z zewnątrz)**: `8141`
- **Host (w sieci Docker)**: `hello-world-remington-mysql`
- **Port wewnętrzny**: `3306`
- **Nazwa bazy danych**: `rem_hw` (zgodnie z `DB_DATABASE` w `.env`)
- **Użytkownik**: `rem_hw`
- **Hasło**: `rem_hw`
- **Użytkownik Root**: `root` / Hasło: `root_pass`

---

## Struktura projektu

Kluczowe katalogi w projekcie:

```text
├── app/
│   ├── Enums/            # Typy wyliczeniowe (UserRole, ShopType, Voivodeship)
│   ├── Http/
│   │   ├── Controllers/  # Kontrolery frontendu, panelu oraz API
│   │   ├── Middleware/   # Filtry żądań (autoryzacja API, sprawdzanie ról, JWT)
│   │   └── Requests/     # Klasy walidacji żądań HTTP (Form Requests)
│   ├── Models/           # Modele Eloquent (Application, Product, Shop, Whence, Link)
│   └── Services/         # Warstwa logiki biznesowej (ApplicationService)
├── database/
│   ├── factories/        # Fabryki danych testowych
│   ├── migrations/       # Migracje schematu bazy danych
│   └── seeders/          # Klasy wypełniające bazę danymi początkowymi
├── docker/
│   └── php/              # Konfiguracja vhosta Apache i skrypt entrypoint.sh
├── resources/
│   ├── js/               # Skrypty JavaScript aplikacji
│   ├── sass/             # Arkusze stylów SCSS (osobne dla frontu i panelu)
│   └── views/            # Widoki Blade (komponenty, frontend, panel)
├── routes/
│   ├── web.php           # Trasy dla widoków przeglądarkowych (front + panel)
│   └── api.php           # Trasy dla interfejsu programistycznego REST API
├── tests/
│   ├── Feature/          # Testy integracyjne
│   ├── Http/             # Testy kontrolerów oraz walidacji żądań HTTP
│   └── Unit/             # Testy jednostkowe
├── Dockerfile_Httpd      # Definicja kontenera Apache + PHP 8.0
└── docker-compose.yaml   # Definicja wielokontenerowego środowiska
```

---

## API REST

Aplikacja udostępnia zestaw tras REST API w prefiksie `/api/`:

### Trasy publiczne:
- `GET /api/product/link/{product}` – pobranie linków partnerskich powiązanych z produktem.

### Trasy zabezpieczone (`api.keys`, `api.auth`):
- **Zgłoszenia**:
  - `GET /api/applications` – lista zgłoszeń z filtrowaniem i paginacją.
- **Sklepy**:
  - `GET /api/shops` – lista sklepów.
  - `POST /api/shops` – dodanie nowego sklepu.
  - `PUT /api/shops` – aktualizacja sklepu.
  - `DELETE /api/shops/{shop}` – usunięcie sklepu.
- **Produkty**:
  - `GET /api/products` – katalog produktów.
  - `POST /api/products` – dodanie produktu.
  - `PUT /api/products` – edycja produktu.
  - `DELETE /api/products/{product}` – usunięcie produktu.
  - `GET /api/products/{product}/links` – lista linków dla produktu.
- **Źródła informacji ("Skąd wiesz")**:
  - `GET /api/whences` – lista źródeł ankietowych.
  - `POST /api/whences` / `PUT /api/whences` / `DELETE /api/whences/{whence}`
- **Linki**:
  - `GET /api/links` / `POST /api/links` / `PUT /api/links` / `DELETE /api/links/{link}`

---

## Przydatne polecenia dla programistów

Wszystkie polecenia developerskie można wykonywać bezpośrednio w środowisku kontenera.

### Podgląd logów w czasie rzeczywistym
```bash
# Logi wszystkich serwisów
docker compose logs -f

# Logi kontenera aplikacji PHP/Apache
docker compose logs -f httpd
```

### Logowanie do konsoli kontenera
```bash
docker compose exec httpd bash
```

### Polecenia narzędzia Artisan
```bash
# Sprawdzenie listy zarejestrowanych tras
docker compose exec httpd php artisan route:list

# Interaktywna konsola Laravel Tinker
docker compose exec httpd php artisan tinker

# Ponowne wyczyszczenie pamięci podręcznej
docker compose exec httpd php artisan optimize:clear
```

### Praca z assetami front-endowymi (SCSS / JS)
```bash
# Jednorazowa kompilacja deweloperska
docker compose exec httpd npm run dev

# Kompilacja produkcyjna (minifikacja)
docker compose exec httpd npm run prod

# Nasłuchiwanie zmian w plikach na żywo (watch mode)
docker compose exec httpd npm run watch
```

### Zatrzymywanie i restart środowiska
```bash
# Zatrzymanie kontenerów
docker compose stop

# Usunięcie kontenerów i sieci z zachowaniem danych w wolumenach
docker compose down

# Pełny reset (usunięcie kontenerów i wolumenów bazy danych)
docker compose down -v
```

---

## Uruchamianie testów

Projekt posiada obszerny zestaw testów automatycznych (ponad 250 testów jednostkowych, kontrolerów i walidacji):

```bash
# Uruchomienie pełnego pakietu testów PHPUnit
docker compose exec httpd ./vendor/bin/phpunit

# Uruchomienie z poziomu artisan test
docker compose exec httpd php artisan test

# Uruchomienie wybranego zestawu testów (np. testy żądań i kontrolerów HTTP)
docker compose exec httpd ./vendor/bin/phpunit tests/Http
```
