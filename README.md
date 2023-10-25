#Strurktura Programu 

 Encja RealisedService  reperezentuje obiekt realizowanej usługi , realizowana usługa jest na rzec encji Klient (many to one relacja ) i moze mieć encje service attachment - załaczniki do usługi  np zdjęcia.

#Do zrobienia
do formuarza dodawania usługi dodać zapis do zużytych części i zminusować magazyn
na usunięcie usługi wywalić zdjęcia z dysku
walidacja Formularzy

# Przydatne komendy 
php bin/console doctrine:schema:update --force 
php bin/console doctrine:fixtures:load