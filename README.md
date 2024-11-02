#Strurktura Programu

Encja RealisedService reperezentuje obiekt realizowanej usługi, realizowana usługa jest na rzecz encji Klient (many to
one relacja) i może mieć encje service attachment - załaczniki do usługi np zdjęcia.

# Do zrobienia

- do formularza dodawania usługi dodać zapis do zużytych części i zminusować magazyn
- na usunięcie usługi wywalić zdjęcia z dysku - do sprawdzenia czy działa
- walidacja Formularzy
- Usiwaniaie stawek VAT

# Przydatne komendy

php bin/console doctrine:schema:update --force
php bin/console doctrine:fixtures:load