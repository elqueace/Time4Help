<?php

namespace App\DataFixtures;
use App\Entity\User;
use App\Entity\Notation;
use App\Entity\Meal;
use App\Entity\Booking;
use App\Entity\Address;
use App\Entity\Message;
use App\Entity\Picture;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Faker;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

class AppFixtures extends Fixture
{
    public function __construct(UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->passwordEncoder = $passwordEncoder;
    }

    public function load(ObjectManager $manager)
    {
         // On configure dans quelles langues nous voulons nos données
        $faker = Faker\Factory::create('fr_FR');
        \Stripe\Stripe::setApiKey('sk_test_eVxSmneYt3p7j9FH32xajzmG');

            //////////////////////////////////////USERS/////////////////////////////////////
          
            // user1 possede une addresse
        


            $user1 = new User();
            $user1->setEmail("eric.pecheur@gmail.com");
            $user1->setFirstName("Eric");
            $user1->setLastName("Pecheur");
            $user1->setPhone($faker->phoneNumber);
            $user1->setGender(false);
            $user1->setPseudo("EricP");
            $user1->setDescription("kbjbljb ljkjk"
                                  );
            $password = "654321qwerty";
            $user1->setPassword($this->passwordEncoder->encodePassword($user1, $password));
            $user1->setRoles(['ROLE_ADMIN']);
            $user1->setAvatar("/images/avatars/EricP.jpg");
            $manager->persist($user1);
            $manager->flush();



            // Create a Stripe Customer:
            if($user1->getCustomerPaymentId() == null)
            {
              $customer = \Stripe\Customer::create([
                'source' => 'tok_visa',
                'email' => $user1->getEmail(),
              ]);
              $user1->setCustomerPaymentId($customer->id);

            }
            $user2 = new User();
            $user2->setEmail("maryse.vanderhorn@outlook.fr");
            $user2->setFirstName("Maryse");
            $user2->setLastName("VANDERHORN");
            $user2->setPhone($faker->phoneNumber);
            $user2->setGender(true);
            $user2->setPseudo("MVand");
            $user2->setDescription($faker->text);
            $password = "azerty";
            $user2->setPassword($this->passwordEncoder->encodePassword($user2, $password));
            $user2->setRoles(['ROLE_ADMIN']);
            $user2->setAvatar("/images/avatars/MVan.png");
            $manager->persist($user2);
            $manager->flush();

            
            $address1 = new Address();
            $address1->setStreet("35 rue Jean Dolent");
            $address1->setZc("75000");
            $address1->setCity("Paris");
            $address1->setCountry("France");
            $address1->setIsDefault(true);
            $address1->setHost($user1);
            $manager->persist($address1);
            $manager->flush();


            // user2 possede une addresse
            $address2 = new Address();
            $address2->setStreet("Bamberger Str. 19");
            $address2->setZc("10779");
            $address2->setCity("Berlin");
            $address2->setCountry("Allemagne");
            $address2->setIsDefault(true);
            $address2->setHost($user2);
            $manager->persist($address2);
            $manager->flush();

            // Create a Stripe Customer:
            if($user2->getCustomerPaymentId() == null)
            {
             $customer = \Stripe\Customer::create([
                'source' => 'tok_visa',
                'email' => $user2->getEmail(),
              ]);
              $user2->setCustomerPaymentId($customer->id);
            }

            //user2 Maryse create a meal
            $meal = new Meal();
            $meal->setTitle("THE SO FRENCH DINNER");
            $meal->setDescription('<p style="color:black;font-size:17px;"><bdi dir="auto" style="color: rgb(53, 53, 48); font-family: circular, sans-serif; text-align: justify; white-space: pre-line; display: block;"><bdi dir="auto" style="display: block;">Explore the cuisines of Brittany, Provence, Corsica and Paris from the comfort of your hosts\'s home. You\'ll embark on a culinary tour of France during this typically French dinner.<br></bdi><bdi dir="auto" style="display: block;"><br></bdi><bdi dir="auto" style="display: block;">• 4-course dinner featuring specialities from all around France<br></bdi><bdi dir="auto" style="display: block;">• Aperitif and wine are included, guests can also BYOB<br></bdi><bdi dir="auto" style="display: block;">• Communal dining for 5 to 12 people<br></bdi><bdi dir="auto" style="display: block;">• Françoise has over 35 rave reviews on TripAdvisor! <br></bdi><bdi dir="auto" style="display: block;"><br></bdi><bdi dir="auto" style="display: block;">About your host, Françoise: "I\'m a chef with my own catering company that caters for companies like Café Elephant Paname, luxury brands, magazines, Fashion Week shows and photo production teams. I can’t eat anything without smelling it before and I always spend a couple of days a month abroad to discover new food."</bdi></bdi></p><h3 class="__title" dir="auto" style="font-family: circular, sans-serif; line-height: 1.1; color: rgb(143, 142, 135); margin-top: 24px; margin-bottom: 32px; font-size: 2rem; letter-spacing: 1px; text-transform: uppercase;"><br></h3><h3 class="__title" dir="auto" style="font-family: circular, sans-serif; line-height: 1.1; color: rgb(143, 142, 135); margin-top: 24px; margin-bottom: 32px; font-size: 2rem; letter-spacing: 1px; text-transform: uppercase;">MENU</h3><p><bdi dir="auto" style="color: rgb(53, 53, 48); font-family: circular, sans-serif; text-align: justify; white-space: pre-line; display: block;"><bdi dir="auto" style="display: block;"></bdi></bdi></p><div class="EventPage-Menu" style="color: rgb(53, 53, 48); font-family: circular, sans-serif;"><div class="__menuDescription" style="text-align: center; font-size: 1.6rem; line-height: 24px; letter-spacing: 1px; padding-bottom: 16px;"><h4 class="__descriptionTitle" dir="auto" style="font-family: circular, sans-serif; line-height: 18px; color: rgb(53, 53, 48); margin-top: 11px; margin-bottom: 4px; font-size: 1.4rem; text-transform: uppercase; letter-spacing: 3px;">APERITIF</h4><div><h5 dir="auto" class="__itemTitle" style="font-family: circular, sans-serif; line-height: 1.1; margin-bottom: 11px; font-size: 2rem; text-transform: uppercase; letter-spacing: 3px;">SEASONAL COCKTAIL BOUCHÉES</h5></div><hr class="separator" style="margin-top: 22px; margin-bottom: 22px; border-top-color: rgb(223, 226, 231); width: 148.792px;"></div><div class="__menuDescription" style="text-align: center; font-size: 1.6rem; line-height: 24px; letter-spacing: 1px; padding-bottom: 16px;"><h4 class="__descriptionTitle" dir="auto" style="font-family: circular, sans-serif; line-height: 18px; color: rgb(53, 53, 48); margin-top: 11px; margin-bottom: 4px; font-size: 1.4rem; text-transform: uppercase; letter-spacing: 3px;">ENTREE</h4><div><h5 dir="auto" class="__itemTitle" style="font-family: circular, sans-serif; line-height: 1.1; margin-bottom: 11px; font-size: 2rem; text-transform: uppercase; letter-spacing: 3px;">THE CHEESE SOUFFLÉ</h5><p class="__itemBody" style="margin-right: 0px; margin-bottom: 11px; margin-left: 0px; color: rgb(143, 142, 135); white-space: pre-line; font-size: inherit; letter-spacing: 0px;"><bdi dir="auto" style="display: block;">a classic from Parisian brasseries<br></bdi><bdi dir="auto" style="display: block;">served with aromatic herbs, fruits &amp; salad mix<br></bdi></p></div><hr class="separator" style="margin-top: 22px; margin-bottom: 22px; border-top-color: rgb(223, 226, 231); width: 148.792px;"></div><div class="__menuDescription" style="text-align: center; font-size: 1.6rem; line-height: 24px; letter-spacing: 1px; padding-bottom: 16px;"><h4 class="__descriptionTitle" dir="auto" style="font-family: circular, sans-serif; line-height: 18px; color: rgb(53, 53, 48); margin-top: 11px; margin-bottom: 4px; font-size: 1.4rem; text-transform: uppercase; letter-spacing: 3px;">MAIN COURSE</h4><div><h5 dir="auto" class="__itemTitle" style="font-family: circular, sans-serif; line-height: 1.1; margin-bottom: 11px; font-size: 2rem; text-transform: uppercase; letter-spacing: 3px;">"BOEUF BOURGUIGNON À LA PROVENÇALE"</h5><p class="__itemBody" style="margin-right: 0px; margin-bottom: 11px; margin-left: 0px; color: rgb(143, 142, 135); white-space: pre-line; font-size: inherit; letter-spacing: 0px;"><bdi dir="auto" style="display: block;">THE "Daube Niçoise", macerated all night in Madiran wine <br></bdi><bdi dir="auto" style="display: block;">and slow-cooked for 6 hours like a confit.<br></bdi></p></div><hr class="separator" style="margin-top: 22px; margin-bottom: 22px; border-top-color: rgb(223, 226, 231); width: 148.792px;"></div><div class="__menuDescription" style="text-align: center; font-size: 1.6rem; line-height: 24px; letter-spacing: 1px; padding-bottom: 16px;"><h4 class="__descriptionTitle" dir="auto" style="font-family: circular, sans-serif; line-height: 18px; color: rgb(53, 53, 48); margin-top: 11px; margin-bottom: 4px; font-size: 1.4rem; text-transform: uppercase; letter-spacing: 3px;">FIRST DESSERT</h4><div><h5 dir="auto" class="__itemTitle" style="font-family: circular, sans-serif; line-height: 1.1; margin-bottom: 11px; font-size: 2rem; text-transform: uppercase; letter-spacing: 3px;">LEMON FIADONE</h5><p class="__itemBody" style="margin-right: 0px; margin-bottom: 11px; margin-left: 0px; color: rgb(143, 142, 135); white-space: pre-line; font-size: inherit; letter-spacing: 0px;"><bdi dir="auto" style="display: block;">speciality from Corsica<br></bdi><bdi dir="auto" style="display: block;"><br></bdi></p></div><hr class="separator" style="margin-top: 22px; margin-bottom: 22px; border-top-color: rgb(223, 226, 231); width: 148.792px;"></div><div class="__menuDescription" style="text-align: center; font-size: 1.6rem; line-height: 24px; letter-spacing: 1px; padding-bottom: 16px;"><h4 class="__descriptionTitle" dir="auto" style="font-family: circular, sans-serif; line-height: 18px; color: rgb(53, 53, 48); margin-top: 11px; margin-bottom: 4px; font-size: 1.4rem; text-transform: uppercase; letter-spacing: 3px;">SECOND DESSERT</h4><div><h5 dir="auto" class="__itemTitle" style="font-family: circular, sans-serif; line-height: 1.1; margin-bottom: 11px; font-size: 2rem; text-transform: uppercase; letter-spacing: 3px;">RED FRUITS IN A REFRESHING MINT JUICE OR ROSE AND CITRUS FRUITS</h5></div></div><div class="__menuDescription" style="text-align: center; font-size: 1.6rem; line-height: 24px; letter-spacing: 1px; padding-bottom: 16px;"><hr class="separator" style="margin-top: 22px; margin-bottom: 22px; border-top-color: rgb(223, 226, 231); width: 148.792px;"><h5 dir="auto" class="__itemTitle" style="font-family: circular, sans-serif; line-height: 1.1; margin-bottom: 11px; font-size: 2rem; text-transform: uppercase; letter-spacing: 3px;">BOISSONS</h5><p dir="auto" class="__itemBody" style="margin-right: 0px; margin-bottom: 11px; margin-left: 0px; color: rgb(143, 142, 135); white-space: pre-line; font-size: inherit; letter-spacing: 0px;">Les invités peuvent apporter de l\'alcool, Vin, Apéritif</p></div></div>');
            $meal->setPrice(16);
            $date = date_create_from_format('j-M-Y', '09-Jul-2019');
            $meal->setDateMeal($date);
            $meal->setMaxTraveller(9);
            $meal->setHost($user2);
            $meal->setAddress($address2);
            $manager->persist($meal);
            $manager->flush();

            $picture = new Picture();
            $picture->setMeal($meal);
            $picture->setPath('/images/all/plat7a.jpg');
            $manager->persist($picture);
            $manager->flush();

            $picture = new Picture();
            $picture->setMeal($meal);
            $picture->setPath('/images/all/plat7b.jpg');
            $manager->persist($picture);
            $manager->flush();

            $picture = new Picture();
            $picture->setMeal($meal);
            $picture->setPath('/images/all/plat7c.jpg');
            $manager->persist($picture);
            $manager->flush();

            $picture = new Picture();
            $picture->setMeal($meal);
            $picture->setPath('/images/all/plat7d.jpg');
            $manager->persist($picture);
            $manager->flush();

        for ($i = 4; $i < 8; $i++) {
          $otherUser = new User();
          $firstname = $faker->firstName;
          $lastname = $faker->lastName;
          $otherUser->setEmail("user".$i."@gmail.com");
          $otherUser->setFirstName($firstname);
          $otherUser->setLastName($lastname);
          $otherUser->setPhone($faker->phoneNumber);
          $otherUser->setGender($faker->boolean);
          $pseudo = substr($firstname,0,1);
          $otherUser->setPseudo($pseudo.$lastname);
          $otherUser->setDescription($faker->text);
          $password = "654321qwerty";
          $otherUser->setPassword($this->passwordEncoder->encodePassword($otherUser, $password));
          $otherUser->setRoles(['ROLE_USER']);
          $otherUser->setAvatar("/images/avatars/"."user".$i.".jpg");
          $manager->persist($otherUser);

          if($i == 4)
          {
            $address = new Address();
            $address->setStreet("8 rue Danton");
            $address->setZc("75000");
            $address->setCity("Paris");
            $address->setCountry("France");
            $address->setIsDefault(true);
            $address->setHost($otherUser);
            $manager->persist($address);
            $manager->flush();

            $meal = new Meal();
            $meal->setTitle("DÎNER GASTRONOMIQUE AVEC UN MASTERCHEF");
            $meal->setDescription('<p style="color:black;font-size:17px;"><bdi dir="auto" style="color: rgb(53, 53, 48); font-family: circular, sans-serif; text-align: justify; white-space: pre-line; display: block;"><bdi dir="auto" style="display: block;"><bdi dir="auto" style="display: block;">Dîner accord mets et vins en 4 services avec le gagnant de l\'édition 2012 de MasterChef France<br></bdi><bdi dir="auto" style="display: block;"><br></bdi><bdi dir="auto" style="display: block;">• Un menu fusion franco-asiatique avec une combinaison subtile des techniques de cuisine traditionnelles françaises et des saveurs asiatiques<br></bdi><bdi dir="auto" style="display: block;">• Une coupe de champagne en apéritif et des vins soigneusement choisis<br></bdi><bdi dir="auto" style="display: block;">• 1 table exclusive de 12 invités venus du monde entier<br></bdi><bdi dir="auto" style="display: block;">• Dans une ancienne cave à vin près du Marais <br></bdi><bdi dir="auto" style="display: block;">• Cette expérience a reçu le Certificat d\'Excellence de TripAdvisor<br></bdi><bdi dir="auto" style="display: block;"><br></bdi><bdi dir="auto" style="display: block;">A propos de votre hôte Jean-Yves: <br></bdi><bdi dir="auto" style="display: block;">" Avec ce menu, je vous emmène dans un voyage culinaire avec la France et l\'Asie. Je vous partagerai les inspirations et les secrets derrière chaque plat. Vous découvrirez comment chaque ingrédient a été spécialement choisi pour créer une parfaite harmonie de goûts et de couleurs."</bdi></bdi></bdi></p><p style="color:black"><bdi dir="auto" style="color: rgb(53, 53, 48); font-family: circular, sans-serif; text-align: justify; white-space: pre-line; display: block;"><bdi dir="auto" style="display: block;"><bdi dir="auto" style="display: block;"><br></bdi></bdi></bdi></p><h3 class="__title" dir="auto" style="font-family: circular, sans-serif; line-height: 1.1; color: rgb(143, 142, 135); margin-top: 24px; margin-bottom: 32px; font-size: 2rem; letter-spacing: 1px; text-transform: uppercase;">MENU</h3><p><bdi dir="auto" style="color: rgb(53, 53, 48); font-family: circular, sans-serif; text-align: justify; white-space: pre-line; display: block;"><bdi dir="auto" style="display: block;"><bdi dir="auto" style="display: block;"></bdi></bdi></bdi></p><div class="EventPage-Menu" style="color: rgb(53, 53, 48); font-family: circular, sans-serif;"><div class="__menuDescription" style="text-align: center; font-size: 1.6rem; line-height: 24px; letter-spacing: 1px; padding-bottom: 16px;"><h4 class="__descriptionTitle" dir="auto" style="font-family: circular, sans-serif; line-height: 18px; color: rgb(53, 53, 48); margin-top: 11px; margin-bottom: 4px; font-size: 1.4rem; text-transform: uppercase; letter-spacing: 3px;">COCKTAIL DE BIENVENUE</h4><div><h5 dir="auto" class="__itemTitle" style="font-family: circular, sans-serif; line-height: 1.1; margin-bottom: 11px; font-size: 2rem; text-transform: uppercase; letter-spacing: 3px;">COUPE DE CHAMPAGNE ET SPHÈRES MOLÉCULAIRES</h5></div><hr class="separator" style="margin-top: 22px; margin-bottom: 22px; border-top-color: rgb(223, 226, 231); width: 148.792px;"></div><div class="__menuDescription" style="text-align: center; font-size: 1.6rem; line-height: 24px; letter-spacing: 1px; padding-bottom: 16px;"><h4 class="__descriptionTitle" dir="auto" style="font-family: circular, sans-serif; line-height: 18px; color: rgb(53, 53, 48); margin-top: 11px; margin-bottom: 4px; font-size: 1.4rem; text-transform: uppercase; letter-spacing: 3px;">EN INTRODUCTION</h4><div><h5 dir="auto" class="__itemTitle" style="font-family: circular, sans-serif; line-height: 1.1; margin-bottom: 11px; font-size: 2rem; text-transform: uppercase; letter-spacing: 3px;">LES ROULEAUX DE MME BUTTERFLY</h5><p class="__itemBody" style="margin-right: 0px; margin-bottom: 11px; margin-left: 0px; color: rgb(143, 142, 135); white-space: pre-line; font-size: inherit; letter-spacing: 0px;"><bdi dir="auto" style="display: block;">Volaille marinée au gingembre, cardamone et cannelle enrobée dans une fine galette de riz, servie fraîche et croquante.<br></bdi></p></div><hr class="separator" style="margin-top: 22px; margin-bottom: 22px; border-top-color: rgb(223, 226, 231); width: 148.792px;"></div><div class="__menuDescription" style="text-align: center; font-size: 1.6rem; line-height: 24px; letter-spacing: 1px; padding-bottom: 16px;"><h4 class="__descriptionTitle" dir="auto" style="font-family: circular, sans-serif; line-height: 18px; color: rgb(53, 53, 48); margin-top: 11px; margin-bottom: 4px; font-size: 1.4rem; text-transform: uppercase; letter-spacing: 3px;">POUR CONTINUER</h4><div><h5 dir="auto" class="__itemTitle" style="font-family: circular, sans-serif; line-height: 1.1; margin-bottom: 11px; font-size: 2rem; text-transform: uppercase; letter-spacing: 3px;">RAVIOLES IMPÉRIALES</h5><p class="__itemBody" style="margin-right: 0px; margin-bottom: 11px; margin-left: 0px; color: rgb(143, 142, 135); white-space: pre-line; font-size: inherit; letter-spacing: 0px;"><bdi dir="auto" style="display: block;">Pâte au riz et tapioca garnie de gambas de Thaïlande et de châtaigne<br></bdi><bdi dir="auto" style="display: block;">d’eau du Vietnam sur une émulsion chaude au « Saté », cuisson à l’étuvée<br></bdi></p></div><hr class="separator" style="margin-top: 22px; margin-bottom: 22px; border-top-color: rgb(223, 226, 231); width: 148.792px;"></div><div class="__menuDescription" style="text-align: center; font-size: 1.6rem; line-height: 24px; letter-spacing: 1px; padding-bottom: 16px;"><h4 class="__descriptionTitle" dir="auto" style="font-family: circular, sans-serif; line-height: 18px; color: rgb(53, 53, 48); margin-top: 11px; margin-bottom: 4px; font-size: 1.4rem; text-transform: uppercase; letter-spacing: 3px;">POUR LE PLAISIR</h4><div><h5 dir="auto" class="__itemTitle" style="font-family: circular, sans-serif; line-height: 1.1; margin-bottom: 11px; font-size: 2rem; text-transform: uppercase; letter-spacing: 3px;">DUCKY DUCK</h5><p class="__itemBody" style="margin-right: 0px; margin-bottom: 11px; margin-left: 0px; color: rgb(143, 142, 135); white-space: pre-line; font-size: inherit; letter-spacing: 0px;"><bdi dir="auto" style="display: block;">Magret de canard à la Yakitori sauce, dôme de courgette, mousseline de patate<br></bdi><bdi dir="auto" style="display: block;">douce et crème de coco, sauté de pousse de bambou, cuisson basse température<br></bdi></p></div><hr class="separator" style="margin-top: 22px; margin-bottom: 22px; border-top-color: rgb(223, 226, 231); width: 148.792px;"></div><div class="__menuDescription" style="text-align: center; font-size: 1.6rem; line-height: 24px; letter-spacing: 1px; padding-bottom: 16px;"><h4 class="__descriptionTitle" dir="auto" style="font-family: circular, sans-serif; line-height: 18px; color: rgb(53, 53, 48); margin-top: 11px; margin-bottom: 4px; font-size: 1.4rem; text-transform: uppercase; letter-spacing: 3px;">EN CONCLUSION</h4><div><h5 dir="auto" class="__itemTitle" style="font-family: circular, sans-serif; line-height: 1.1; margin-bottom: 11px; font-size: 2rem; text-transform: uppercase; letter-spacing: 3px;">SPÉCIALITÉ DU CHEF</h5><p class="__itemBody" style="margin-right: 0px; margin-bottom: 11px; margin-left: 0px; color: rgb(143, 142, 135); white-space: pre-line; font-size: inherit; letter-spacing: 0px;"><bdi dir="auto" style="display: block;">Macaron aux saveurs exotiques et saké maison<br></bdi></p></div><hr class="separator" style="margin-top: 22px; margin-bottom: 22px; border-top-color: rgb(223, 226, 231); width: 148.792px;"></div><div class="__menuDescription" style="text-align: center; font-size: 1.6rem; line-height: 24px; letter-spacing: 1px; padding-bottom: 16px;"><h4 class="__descriptionTitle" dir="auto" style="font-family: circular, sans-serif; line-height: 18px; color: rgb(53, 53, 48); margin-top: 11px; margin-bottom: 4px; font-size: 1.4rem; text-transform: uppercase; letter-spacing: 3px;">VINS</h4><div><h5 dir="auto" class="__itemTitle" style="font-family: circular, sans-serif; line-height: 1.1; margin-bottom: 11px; font-size: 2rem; text-transform: uppercase; letter-spacing: 3px;">BOURGOGNE CÔTE CHÂLONNAISE AOP CHARDONNAY/MILLEBUIS 2016</h5><div class="bullet-separator" style="margin-bottom: 16px;"><div class="small bullet" style="font-size: 13.92px; display: inline-block; margin: 0px 4px; border-radius: 50%; background-color: rgb(223, 226, 231); vertical-align: middle; width: 4px; height: 4px;"></div><div class="big bullet" style="display: inline-block; margin: 0px 4px; border-radius: 50%; background-color: rgb(223, 226, 231); vertical-align: middle; width: 6px; height: 6px;"></div><div class="small bullet" style="font-size: 13.92px; display: inline-block; margin: 0px 4px; border-radius: 50%; background-color: rgb(223, 226, 231); vertical-align: middle; width: 4px; height: 4px;"></div></div></div><div><h5 dir="auto" class="__itemTitle" style="font-family: circular, sans-serif; line-height: 1.1; margin-bottom: 11px; font-size: 2rem; text-transform: uppercase; letter-spacing: 3px;">CHÂTEAU VICTORIA CRU BOURGEOIS 2014</h5></div></div><div class="__menuDescription" style="text-align: center; font-size: 1.6rem; line-height: 24px; letter-spacing: 1px; padding-bottom: 16px;"><hr class="separator" style="margin-top: 22px; margin-bottom: 22px; border-top-color: rgb(223, 226, 231); width: 148.792px;"><h5 dir="auto" class="__itemTitle" style="font-family: circular, sans-serif; line-height: 1.1; margin-bottom: 11px; font-size: 2rem; text-transform: uppercase; letter-spacing: 3px;">BOISSONS</h5><p dir="auto" class="__itemBody" style="margin-right: 0px; margin-bottom: 11px; margin-left: 0px; color: rgb(143, 142, 135); white-space: pre-line; font-size: inherit; letter-spacing: 0px;">Vin rouge, Vin blanc, Apéritif</p></div></div>');
            $meal->setPrice(13);
            $date = date_create_from_format('j-M-Y', '13-Jul-2019');
            $meal->setDateMeal($date);
            $meal->setMaxTraveller($i);
            $meal->setHost($otherUser);
            $meal->setAddress($address);
              $notation = new Notation();
              $notation->setRating(rand(2,5));
              $date = date_create_from_format('j-M-Y', '13-Jul-2019');
              $notation->setDate($date);
              $notation->setMeal($meal);

              $notation->setComment('Classique mais efficace. endroit calme. belle terrasse quand il fait beau.');
              $notation->setGiver($user1);
              $notation->setReceiver($user2);

              $notation->setIsAnonymous(false);
              $notation->setIsVisible(true);
              $manager->persist($notation);

              $notation = new Notation();
              $notation->setRating(rand(2,5));
              $date = date_create_from_format('j-M-Y', '13-Jul-2019');
              $notation->setDate($date);
              $notation->setMeal($meal);

              $notation->setComment('Très bon repas, ambiance conviviale, à refaire!');
              $notation->setGiver($user2);
              $notation->setReceiver($user1);

              $notation->setIsAnonymous(false);
              $notation->setIsVisible(true);
              $manager->persist($notation);
            $manager->persist($meal);
            $manager->flush();

            
            $picture = new Picture();
            $picture->setPath('/images/all/plat4a.jpg');
            $manager->persist($picture);
            $manager->flush();

            $picture = new Picture();
            $picture->setMeal($meal);
            $picture->setPath('/images/all/plat4b.jpg');
            $manager->persist($picture);
            $manager->flush();

            $picture = new Picture();
            $picture->setMeal($meal);
            $picture->setPath('/images/all/plat4c.jpg');
            $manager->persist($picture);
            $manager->flush();

            $picture = new Picture();
            $picture->setMeal($meal);
            $picture->setPath('/images/all/plat4d.jpg');
            $manager->persist($picture);
            $manager->flush();

          }
          elseif($i == 5)
          {
            $address = new Address();
            $address->setStreet("8 rue Gaillon");
            $address->setZc("75000");
            $address->setCity("Paris");
            $address->setCountry("France");
            $address->setIsDefault(true);
            $address->setHost($otherUser);
            $manager->persist($address);
            $manager->flush();

            $meal = new Meal();
            $meal->setTitle("FRENCH DINNER IN PARIS");
            $meal->setDescription('<p style="color:black;font-size:17px;"><bdi dir="auto" style="color: rgb(53, 53, 48); font-family: circular, sans-serif; text-align: justify; white-space: pre-line; display: block;"><bdi dir="auto" style="display: block;"><bdi dir="auto" style="display: block;"><bdi dir="auto" style="display: block;"><bdi dir="auto" style="display: block;">I will be happy to meet you, in my home, for a typical french diner. Paris is not just Tour Eiffel, restaurants and "cafés". It\'s also about meeting people, eat french food and discover a wonderful place : the 19th arrondissement (visit parc des Buttes Chaumont, canal de l\'Ourcq).<br></bdi><bdi dir="auto" style="display: block;">I offer a great moment, drinks and typical french cuisine and explain how I live in Paris. You will be a true Parisian !</bdi></bdi></bdi></bdi></bdi></p><p style="color:black"><bdi dir="auto" style="color: rgb(53, 53, 48); font-family: circular, sans-serif; text-align: justify; white-space: pre-line; display: block;"><bdi dir="auto" style="display: block;"><bdi dir="auto" style="display: block;"><bdi dir="auto" style="display: block;"><bdi dir="auto" style="display: block;"><br></bdi></bdi></bdi></bdi></bdi></p><h3 class="__title" dir="auto" style="font-family: circular, sans-serif; line-height: 1.1; color: rgb(143, 142, 135); margin-top: 24px; margin-bottom: 32px; font-size: 2rem; letter-spacing: 1px; text-transform: uppercase;">MENU</h3><p><bdi dir="auto" style="color: rgb(53, 53, 48); font-family: circular, sans-serif; text-align: justify; white-space: pre-line; display: block;"><bdi dir="auto" style="display: block;"><bdi dir="auto" style="display: block;"><bdi dir="auto" style="display: block;"><bdi dir="auto" style="display: block;"></bdi></bdi></bdi></bdi></bdi></p><div class="EventPage-Menu" style="color: rgb(53, 53, 48); font-family: circular, sans-serif;"><div class="__menuDescription" style="text-align: center; font-size: 1.6rem; line-height: 24px; letter-spacing: 1px; padding-bottom: 16px;"><h4 class="__descriptionTitle" dir="auto" style="font-family: circular, sans-serif; line-height: 18px; color: rgb(53, 53, 48); margin-top: 11px; margin-bottom: 4px; font-size: 1.4rem; text-transform: uppercase; letter-spacing: 3px;">APERITIF</h4><div><h5 dir="auto" class="__itemTitle" style="font-family: circular, sans-serif; line-height: 1.1; margin-bottom: 11px; font-size: 2rem; text-transform: uppercase; letter-spacing: 3px;">WELCOME DRINK WITH CHAMPAGNE</h5></div><hr class="separator" style="margin-top: 22px; margin-bottom: 22px; border-top-color: rgb(223, 226, 231); width: 148.792px;"></div><div class="__menuDescription" style="text-align: center; font-size: 1.6rem; line-height: 24px; letter-spacing: 1px; padding-bottom: 16px;"><h4 class="__descriptionTitle" dir="auto" style="font-family: circular, sans-serif; line-height: 18px; color: rgb(53, 53, 48); margin-top: 11px; margin-bottom: 4px; font-size: 1.4rem; text-transform: uppercase; letter-spacing: 3px;">STARTER</h4><div><h5 dir="auto" class="__itemTitle" style="font-family: circular, sans-serif; line-height: 1.1; margin-bottom: 11px; font-size: 2rem; text-transform: uppercase; letter-spacing: 3px;">QUICHE LORRAINE</h5><p class="__itemBody" style="margin-right: 0px; margin-bottom: 11px; margin-left: 0px; color: rgb(143, 142, 135); white-space: pre-line; font-size: inherit; letter-spacing: 0px;"><bdi dir="auto" style="display: block;">French quiche (homemade)<br></bdi></p></div><hr class="separator" style="margin-top: 22px; margin-bottom: 22px; border-top-color: rgb(223, 226, 231); width: 148.792px;"></div><div class="__menuDescription" style="text-align: center; font-size: 1.6rem; line-height: 24px; letter-spacing: 1px; padding-bottom: 16px;"><h4 class="__descriptionTitle" dir="auto" style="font-family: circular, sans-serif; line-height: 18px; color: rgb(53, 53, 48); margin-top: 11px; margin-bottom: 4px; font-size: 1.4rem; text-transform: uppercase; letter-spacing: 3px;">MAIN COURSE</h4><div><h5 dir="auto" class="__itemTitle" style="font-family: circular, sans-serif; line-height: 1.1; margin-bottom: 11px; font-size: 2rem; text-transform: uppercase; letter-spacing: 3px;">CARBONNADE HOMEMADE</h5><p class="__itemBody" style="margin-right: 0px; margin-bottom: 11px; margin-left: 0px; color: rgb(143, 142, 135); white-space: pre-line; font-size: inherit; letter-spacing: 0px;"><bdi dir="auto" style="display: block;">Beef stewed (typical french, like a Boeuf bourguignon) with potatoes<br></bdi></p></div><hr class="separator" style="margin-top: 22px; margin-bottom: 22px; border-top-color: rgb(223, 226, 231); width: 148.792px;"></div><div class="__menuDescription" style="text-align: center; font-size: 1.6rem; line-height: 24px; letter-spacing: 1px; padding-bottom: 16px;"><h4 class="__descriptionTitle" dir="auto" style="font-family: circular, sans-serif; line-height: 18px; color: rgb(53, 53, 48); margin-top: 11px; margin-bottom: 4px; font-size: 1.4rem; text-transform: uppercase; letter-spacing: 3px;">FROMAGES</h4><div><p class="__itemBody" style="margin-right: 0px; margin-bottom: 11px; margin-left: 0px; color: rgb(143, 142, 135); white-space: pre-line; font-size: inherit; letter-spacing: 0px;"><bdi dir="auto" style="display: block;">French cheeses <br></bdi></p></div><hr class="separator" style="margin-top: 22px; margin-bottom: 22px; border-top-color: rgb(223, 226, 231); width: 148.792px;"></div><div class="__menuDescription" style="text-align: center; font-size: 1.6rem; line-height: 24px; letter-spacing: 1px; padding-bottom: 16px;"><h4 class="__descriptionTitle" dir="auto" style="font-family: circular, sans-serif; line-height: 18px; color: rgb(53, 53, 48); margin-top: 11px; margin-bottom: 4px; font-size: 1.4rem; text-transform: uppercase; letter-spacing: 3px;">DESSERT</h4><div><h5 dir="auto" class="__itemTitle" style="font-family: circular, sans-serif; line-height: 1.1; margin-bottom: 11px; font-size: 2rem; text-transform: uppercase; letter-spacing: 3px;">TARTE AU CITRON OU TARTE TATIN OU MOUSSE AU CHOCOLAT</h5><p class="__itemBody" style="margin-right: 0px; margin-bottom: 11px; margin-left: 0px; color: rgb(143, 142, 135); white-space: pre-line; font-size: inherit; letter-spacing: 0px;"><bdi dir="auto" style="display: block;">Lemon pie or apple pie or chocolate mousse<br></bdi></p></div></div><div class="__menuDescription" style="text-align: center; font-size: 1.6rem; line-height: 24px; letter-spacing: 1px; padding-bottom: 16px;"><hr class="separator" style="margin-top: 22px; margin-bottom: 22px; border-top-color: rgb(223, 226, 231); width: 148.792px;"><h5 dir="auto" class="__itemTitle" style="font-family: circular, sans-serif; line-height: 1.1; margin-bottom: 11px; font-size: 2rem; text-transform: uppercase; letter-spacing: 3px;">BOISSONS</h5><p dir="auto" class="__itemBody" style="margin-right: 0px; margin-bottom: 11px; margin-left: 0px; color: rgb(143, 142, 135); white-space: pre-line; font-size: inherit; letter-spacing: 0px;">Champagne, Bière, Vin</p></div></div>');
            $meal->setPrice(12);
            $date = date_create_from_format('j-M-Y', '25-Mar-2019');
            $meal->setDateMeal($date);
            $meal->setMaxTraveller($i);
            $meal->setHost($otherUser);
            $meal->setAddress($address);
            $manager->persist($meal);

              $notation = new Notation();
              $notation->setRating(rand(2,5));
              $date = date_create_from_format('j-M-Y', '13-Jul-2019');
              $notation->setDate($date);
              $notation->setMeal($meal);

              $notation->setComment('Typique et sympathique. Une terrasse au calme. Un personnel agréable et un couscous... Royal.');
              $notation->setGiver($user1);
              $notation->setReceiver($user2);

              $notation->setIsAnonymous(false);
              $notation->setIsVisible(true);
              $manager->persist($notation);
            $manager->flush();

            
            $picture = new Picture();
            $picture->setMeal($meal);
            $picture->setPath('/images/all/plat5a.jpg');
            $manager->persist($picture);
            $manager->flush();

            $picture = new Picture();
            $picture->setMeal($meal);
            $picture->setPath('/images/all/plat5b.jpg');
            $manager->persist($picture);
            $manager->flush();

            $picture = new Picture();
            $picture->setMeal($meal);
            $picture->setPath('/images/all/plat5c.jpg');
            $manager->persist($picture);
            $manager->flush();

            $picture = new Picture();
            $picture->setMeal($meal);
            $picture->setPath('/images/all/plat5d.jpg');
            $manager->persist($picture);
            $manager->flush();

          }
          elseif($i == 6)
          {
            $address = new Address();
            $address->setStreet("60 rue DOrfilaanton");
            $address->setZc("75000");
            $address->setCity("Paris");
            $address->setCountry("France");
            $address->setIsDefault(true);
            $address->setHost($otherUser);
            $manager->persist($address2);
            $manager->flush();

            $meal = new Meal();
            $meal->setTitle("FRENCH DINNER NEAR NOTRE DAME");
            $meal->setDescription('<p style="color:black;font-size:17px;"><bdi dir="auto" style="color: rgb(53, 53, 48); font-family: circular, sans-serif; text-align: justify; white-space: pre-line; display: block;"><bdi dir="auto" style="display: block;"><bdi dir="auto" style="display: block;"><bdi dir="auto" style="display: block;">Casual and fun French Dinner in the center of Paris<br></bdi><bdi dir="auto" style="display: block;"><br></bdi><bdi dir="auto" style="display: block;">• Savor a 3-course dinner with tasty French dishes and wine (e.g roasted camembert and quiches)<br></bdi><bdi dir="auto" style="display: block;">• 10-minutes walk from Notre Dame Cathedral<br></bdi><bdi dir="auto" style="display: block;">• Meet people from all around the world<br></bdi><bdi dir="auto" style="display: block;">• Vegan, vegetarian and gluten-free options are available upon request<br></bdi><bdi dir="auto" style="display: block;"><br></bdi><bdi dir="auto" style="display: block;">About your host Philippe: <br></bdi><bdi dir="auto" style="display: block;"><br></bdi><bdi dir="auto" style="display: block;">“By day, I’m a Paris policeman. By night, I love to host guests from around the world at my table with Dzianis. We’re two guys who love cooking, traveling, and meeting new people. We would be delighted to welcome you into our flat right near Notre-Dame. Join us for a friendly and casual meal around the traditional French quiche.<br></bdi><bdi dir="auto" style="display: block;"><br></bdi><bdi dir="auto" style="display: block;">Don’t hesitate to tell us your allergies and intolerances, we are very flexible with that. And we could satisfy you :-)<br></bdi><bdi dir="auto" style="display: block;"><br></bdi><bdi dir="auto" style="display: block;"><br></bdi><bdi dir="auto" style="display: block;">** Available sometimes at LUNCHTIME &amp; WEEKENDS for a minimum of 6 people and maximum 10 people **<br></bdi><bdi dir="auto" style="display: block;"><br></bdi><bdi dir="auto" style="display: block;">** For PRIVATE EVENTS (minimum 8/10 people) we will offer a BOTTLE OF CHAMPAGNE! 🍾 **</bdi></bdi></bdi></bdi></p><p style="color:black"><bdi dir="auto" style="color: rgb(53, 53, 48); font-family: circular, sans-serif; text-align: justify; white-space: pre-line; display: block;"><bdi dir="auto" style="display: block;"><bdi dir="auto" style="display: block;"><bdi dir="auto" style="display: block;"><br></bdi></bdi></bdi></bdi></p><h3 class="__title" dir="auto" style="font-family: circular, sans-serif; line-height: 1.1; color: rgb(143, 142, 135); margin-top: 24px; margin-bottom: 32px; font-size: 2rem; letter-spacing: 1px; text-transform: uppercase;">MENU</h3><p><bdi dir="auto" style="color: rgb(53, 53, 48); font-family: circular, sans-serif; text-align: justify; white-space: pre-line; display: block;"><bdi dir="auto" style="display: block;"><bdi dir="auto" style="display: block;"><bdi dir="auto" style="display: block;"></bdi></bdi></bdi></bdi></p><div class="EventPage-Menu" style="color: rgb(53, 53, 48); font-family: circular, sans-serif;"><div class="__menuDescription" style="text-align: center; font-size: 1.6rem; line-height: 24px; letter-spacing: 1px; padding-bottom: 16px;"><h4 class="__descriptionTitle" dir="auto" style="font-family: circular, sans-serif; line-height: 18px; color: rgb(53, 53, 48); margin-top: 11px; margin-bottom: 4px; font-size: 1.4rem; text-transform: uppercase; letter-spacing: 3px;">APÉRITIF</h4><div><h5 dir="auto" class="__itemTitle" style="font-family: circular, sans-serif; line-height: 1.1; margin-bottom: 11px; font-size: 2rem; text-transform: uppercase; letter-spacing: 3px;">WELCOME DRINK</h5><p class="__itemBody" style="margin-right: 0px; margin-bottom: 11px; margin-left: 0px; color: rgb(143, 142, 135); white-space: pre-line; font-size: inherit; letter-spacing: 0px;"><bdi dir="auto" style="display: block;">Chilled Rosé Served with our appetizers<br></bdi></p></div><hr class="separator" style="margin-top: 22px; margin-bottom: 22px; border-top-color: rgb(223, 226, 231); width: 148.792px;"></div><div class="__menuDescription" style="text-align: center; font-size: 1.6rem; line-height: 24px; letter-spacing: 1px; padding-bottom: 16px;"><h4 class="__descriptionTitle" dir="auto" style="font-family: circular, sans-serif; line-height: 18px; color: rgb(53, 53, 48); margin-top: 11px; margin-bottom: 4px; font-size: 1.4rem; text-transform: uppercase; letter-spacing: 3px;">STARTER</h4><div><h5 dir="auto" class="__itemTitle" style="font-family: circular, sans-serif; line-height: 1.1; margin-bottom: 11px; font-size: 2rem; text-transform: uppercase; letter-spacing: 3px;">ROASTED CAMEMBERT</h5><p class="__itemBody" style="margin-right: 0px; margin-bottom: 11px; margin-left: 0px; color: rgb(143, 142, 135); white-space: pre-line; font-size: inherit; letter-spacing: 0px;"><bdi dir="auto" style="display: block;">Served with different breads and fresh salad with tomatoes<br></bdi></p></div><hr class="separator" style="margin-top: 22px; margin-bottom: 22px; border-top-color: rgb(223, 226, 231); width: 148.792px;"></div><div class="__menuDescription" style="text-align: center; font-size: 1.6rem; line-height: 24px; letter-spacing: 1px; padding-bottom: 16px;"><h4 class="__descriptionTitle" dir="auto" style="font-family: circular, sans-serif; line-height: 18px; color: rgb(53, 53, 48); margin-top: 11px; margin-bottom: 4px; font-size: 1.4rem; text-transform: uppercase; letter-spacing: 3px;">MAIN COURSE</h4><div><h5 dir="auto" class="__itemTitle" style="font-family: circular, sans-serif; line-height: 1.1; margin-bottom: 11px; font-size: 2rem; text-transform: uppercase; letter-spacing: 3px;">A TRADITIONAL FRENCH QUICHE</h5><p class="__itemBody" style="margin-right: 0px; margin-bottom: 11px; margin-left: 0px; color: rgb(143, 142, 135); white-space: pre-line; font-size: inherit; letter-spacing: 0px;"><bdi dir="auto" style="display: block;">Homemade French quiches with a summer twist from my traditional recipe<br></bdi></p></div><hr class="separator" style="margin-top: 22px; margin-bottom: 22px; border-top-color: rgb(223, 226, 231); width: 148.792px;"></div><div class="__menuDescription" style="text-align: center; font-size: 1.6rem; line-height: 24px; letter-spacing: 1px; padding-bottom: 16px;"><h4 class="__descriptionTitle" dir="auto" style="font-family: circular, sans-serif; line-height: 18px; color: rgb(53, 53, 48); margin-top: 11px; margin-bottom: 4px; font-size: 1.4rem; text-transform: uppercase; letter-spacing: 3px;">DESSERT</h4><div><h5 dir="auto" class="__itemTitle" style="font-family: circular, sans-serif; line-height: 1.1; margin-bottom: 11px; font-size: 2rem; text-transform: uppercase; letter-spacing: 3px;">A SURPRISE!</h5><p class="__itemBody" style="margin-right: 0px; margin-bottom: 11px; margin-left: 0px; color: rgb(143, 142, 135); white-space: pre-line; font-size: inherit; letter-spacing: 0px;"><bdi dir="auto" style="display: block;">Seasonal dessert according to the chef\'s mood<br></bdi></p></div></div><div class="__menuDescription" style="text-align: center; font-size: 1.6rem; line-height: 24px; letter-spacing: 1px; padding-bottom: 16px;"><hr class="separator" style="margin-top: 22px; margin-bottom: 22px; border-top-color: rgb(223, 226, 231); width: 148.792px;"><h5 dir="auto" class="__itemTitle" style="font-family: circular, sans-serif; line-height: 1.1; margin-bottom: 11px; font-size: 2rem; text-transform: uppercase; letter-spacing: 3px;">BOISSONS</h5><p dir="auto" class="__itemBody" style="margin-right: 0px; margin-bottom: 11px; margin-left: 0px; color: rgb(143, 142, 135); white-space: pre-line; font-size: inherit; letter-spacing: 0px;">Vin, Apéritif</p></div></div>');
            $meal->setPrice(15);
            $date = date_create_from_format('j-M-Y', '13-Jul-2019');
            $meal->setDateMeal($date);
            $meal->setMaxTraveller($i);
            $meal->setHost($otherUser);
            $meal->setAddress($address);

          $notation = new Notation();
          $notation->setRating(rand(2,5));
          $date = date_create_from_format('j-M-Y', '13-Jul-2019');
          $notation->setDate($date);
          $notation->setMeal($meal);

          $notation->setComment('Très bon accueil et très bons plats je kiffe');
          $notation->setGiver($user2);
          $notation->setReceiver($user1);

          $notation->setIsAnonymous(false);
          $notation->setIsVisible(true);
          $manager->persist($notation);


            $manager->persist($meal);
            $manager->flush();


            $picture = new Picture();
            $picture->setMeal($meal);
            $picture->setPath('/images/all/plat6a.jpg');
            $manager->persist($picture);
            $manager->flush();

            $picture = new Picture();
            $picture->setMeal($meal);
            $picture->setPath('/images/all/plat6b.jpg');
            $manager->persist($picture);
            $manager->flush();

            $picture = new Picture();
            $picture->setMeal($meal);
            $picture->setPath('/images/all/plat6c.jpg');
            $manager->persist($picture);
            $manager->flush();

            $picture = new Picture();
            $picture->setMeal($meal);
            $picture->setPath('/images/all/plat6d.jpg');
            $manager->persist($picture);
            $manager->flush();



          }
          elseif($i == 7)
          {
            $address = new Address();
            $address->setStreet("18 rue Clisson");
            $address->setZc("75000");
            $address->setCity("Paris");
            $address->setCountry("France");
            $address->setIsDefault(true);
            $address->setHost($otherUser);
            $manager->persist($address);
            $manager->flush();

           

          }
        }

        //////////////////////////////////////ADDRESSES/////////////////////////////////////
        
       
    }

}
