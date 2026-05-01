<?php

namespace App\DataFixtures;

use App\Entity\Salle;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{
    private UserPasswordHasherInterface $passwordHasher;

    public function __construct(UserPasswordHasherInterface $passwordHasher)
    {
        $this->passwordHasher = $passwordHasher;
    }

    public function load(ObjectManager $manager): void
    {
        // Administrateur
        $user = new User();
        $user->setEmail('admin@example.com');
        $user->setRoles(['ROLE_ADMIN']);
        $user->setPassword($this->passwordHasher->hashPassword($user, 'admin123'));
        $manager->persist($user);

        // Utilisateur normal (pour tester les réservations)
        $normalUser = new User();
        $normalUser->setEmail('user@example.com');
        $normalUser->setRoles(['ROLE_USER']);
        $normalUser->setPassword($this->passwordHasher->hashPassword($normalUser, 'user123'));
        $manager->persist($normalUser);

        // Salles du site original
        $salle1 = new Salle();
        $salle1->setNom("Royal Suites Zaragoza");
        $salle1->setDescription("Idéal pour les boards de direction.");
        $salle1->setCapacite(12);
        $salle1->setPrix(50.0);
        $salle1->setImage("https://cf.bstatic.com/xdata/images/hotel/max1024x768/45036687.jpg?k=fdf7463515c42c6f64db306c4ef77745cf84de2306e7fa9e2126df3ae47fe0c8&o=");
        $manager->persist($salle1);

        $salle2 = new Salle();
        $salle2->setNom("Salle de projection");
        $salle2->setDescription("Espace ouvert pour brainstorming.");
        $salle2->setCapacite(20);
        $salle2->setPrix(35.0);
        $salle2->setImage("https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcTXdVjI9x2uJJGG0wTKnYK69ON_UvutbekE2g&s");
        $manager->persist($salle2);

        $salle3 = new Salle();
        $salle3->setNom("Auditorium");
        $salle3->setDescription("Pour vos présentations produits.");
        $salle3->setCapacite(50);
        $salle3->setPrix(100.0);
        $salle3->setImage("https://st.depositphotos.com/1808367/4327/i/450/depositphotos_43274673-stock-photo-theater-seats.jpg");
        $manager->persist($salle3);

        $manager->flush();
    }
}
