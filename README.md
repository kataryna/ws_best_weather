Rozwiązanie:
- WebService zaimplementowano przy wykorzystaniu Lumen Framework oraz biblioteki GuzzleHttp
- Wykorzystano middleware auth do autoryzacji requestów via token
- Cała logika web service znajduje się w plikach: App/Models/City.php , App/Models/CityList.php oraz App/Http/Controllers/ApiWeatherController.php 
- Przykładowe zapytanie:  http://localhost:8000/Gdynia;Sopot;Warszawa , dodatkowo konieczny jest  ustawiony nagłowek 'Api-Token' 
- kilka zapisanych testów  można podejrzeć tutaj https://www.getpostman.com/collections/865d2907723ad296ece5

Zadanie:
Zaimplementuj prosty WebService który obliczy które ze wskazanych miast ma obecnie
“najlepszą” pogodę.
Aby to wyliczyć należy odpytać zewnętrzne API i w oparciu o odpowiedzi - posegregować
miasta wg. następujących kryteriów:
1. Od najcieplejszego do najzimniejszego - Temperature ( waga: 0.6 )
2. Od najbardziej wietrznego do najmniej - Wind ( waga: 0.3 )
3. Od najwyższej wilgotności powietrza do najniższej - Humidity ( waga: 0.1 )
Na podstawie miejsca miasta w każdej z tych kategorii możemy obliczyć jego wynik wg wzoru:
SCORE_FOR_PARAMETER = (100 - 10 * ( POSITION_IN_RANK - 1)) * PARAMETER_MODIFIER
Np. Dla temperatury pierwsze trzy wynik punktowe będą wyglądały następująco:
1. miejsce temperatura = (100 - 10 * (1 - 1)) * 0.6 = 60
2. miejsce temperatura = (100 - 10 * (2 - 1)) * 0.6 = 54
3. miejsce temperatura = (100 - 10 * (3 - 1)) * 0.6 = 48
Wynik końcowy każdego z miast jest sumą wyników w każdej z 3 kategorii.
WebService powinien odpowiadać następującymi danymi
- Obecna data (o której serwis dostał request)
- Lista zawierająca informacje: Nazwa miasta, Wynik końcowy, Temperatura, Wiatr,
Wilgotność
- Lista powinna być posortowana po wyniku końcowym, od najwyższego do najniższego
Założenia:
1. Język programowania: PHP. Ewentualny framework / zewnętrzne biblioteki - dowolne
2. Wykorzystanie darmowego api: https://openweathermap.org/api
3. Jako parametr do requestu podajemy listę z nazwami miast
4. Dostęp do WebService powinien być zabezpieczony kluczem API. Listę kluczy można
zdefiniować jako prostą tablicę i w kodzie. Jeśli request nie ma posiada parametru
apiKey ze znanym kluczem - request nie powinien być autoryzowany
5. Minimalna liczba miast do porównania: 2, maksymalna 4
6. Odpowiedź na request powinna być w formacie JSON lub XML
7. Kod powinien zostać wrzucony na jako repozytorium na githubie

