# BlueBinary

# System Kolejek Górskich - CodeIgniter 4

Projekt rekrutacyjny - system do zarządzania kolejkami górskimi oraz przypisanymi do nich wagonami.

## Technologie

* PHP 8.1+
* CodeIgniter 4
* Redis (dane operacyjne)
* Docker / Docker Compose
* nginx + PHP-FPM
* ReactPHP + clue/reactphp-redis (monitor CLI)

---

## Start (dev)

```bash
make prepare-env
make dev-up
```

Aplikacja będzie dostępna pod: `http://localhost:8080`

## Start (prod)

```bash
make prepare-env-prod
make prod-up
```

Aplikacja będzie dostępna pod: `http://localhost:8090`

## CLI Monitor (dev)

```bash
make monitor
```

Monitor pokazuje w czasie rzeczywistym statusy kolejek górskich (ReactPHP + clue/reactphp-redis).

---

## API Endpoints

### POST /api/coasters

Rejestracja kolejki górskiej

```json
{
  "id": "A1",
  "staffCount": 16,
  "dailyCustomerCount": 60000,
  "trackLength": 1800,
  "hoursFrom": "8:00",
  "hoursTo": "16:00"
}
```

### PUT /api/coasters/\:id

Aktualizacja kolejki (bez zmiany długości trasy)

### POST /api/coasters/\:coasterId/wagons

Dodanie wagonu

```json
{
  "id": "W1",
  "seat_count": 32,
  "speed": 1.2
}
```

### DELETE /api/coasters/\:coasterId/wagons/\:wagonId

Usunięcie wagonu

---

## Zasady działania

### Personel:

* 1 os. na kolejkę
* 2 os. na każdy wagon

### Czas pracy kolejek:

* Każdy wagon musi skończyć trasę przed godziną zamknięcia
* 5 min przerwy po każdym kursie

### Klienci:

* System analizuje czy kolejka może obsłużyć zaplanowaną liczbę klientów
* Jeśli nie: raportuje braki personelu i wagonów
* Jeśli nadmiar: raportuje niepotrzebne zasoby

---

## CLI Monitor

Asynchroniczny CLI napisany w ReactPHP, śledzi:

* Liczbę wagonów i personelu
* Potrzeby dzienne klientów
* Czas pracy kolejek
* Braki i nadmiary zasobów
* Loguje problemy do `writable/logs`

Przykład:

```
[Coaster A2]
1. Operating hours: 09:00 - 17:00
2. Wagons: 6
3. Staff: 8/10
4. Clients (planned / possible): 150 / 100
5. Problem: Missing 2 staff
```

---

## Redis - izolacja danych

Dane w Redis są prefixowane:

* `dev:` dla development
* `prod:` dla produkcji

Ustawiane przez zmienną `REDIS_PREFIX` w `.env`

---

## Przydatne komendy

```bash
make reset             # Całkowite czyszczenie projektu (nie cofniesz!)
make flush-redis       # Czyści Redis (dev)
make flush-redis-prod  # Czyści Redis (prod)
make logs              # Podgląd logów kontenera app
```

Przygotowane na potrzeby zadania rekrutacyjnego.

---

P.S. Dodam tylko od siebie ze nie zrozumialem do konca czy finalnie, do jednej kolejki mozna dodac wiele wagonow czy jeden wagon. Mylaca byla ta informacja 4/6 wagonow. Zinterpretowalem to jak zinterpretowalem i mam nadzieje ze dobrze. I generalnie tylko dodam ze jestem srednie zadowolny z tego zadania, bo troche rzeczy sie nalozylo na raz (w tym planowane wczesniej wakacje) i troche sie z tym pospieszylem. Ale raczej codziennie bede cos zmienial tutaj. Zawsze cos nowego do nauki!
