<?php

namespace App\DataFixtures;

use App\Entity\Task;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class TaskFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        //create 3 task entities based on Task entity , set user  from fixtures reference client1, client2 etc.
        $task1 = new Task();
        $task1->setTitle("Task 1");
        $task1->setDescription("Description of task 1");
        $task1->setDueDate(new \DateTime('2021-12-31'));
        $task1->setCompleted(false);

        $manager->persist($task1);

        $task2 = new Task();
        $task2->setTitle("Task 2");
        $task2->setDescription("Description of task 2");
        $task2->setDueDate(new \DateTime('2021-12-31'));
        $task2->setCompleted(false);

        $manager->persist($task2);

        $task3 = new Task();
        $task3->setTitle("Task 3");
        $task3->setDescription("Description of task 3");
        $task3->setDueDate(new \DateTime('2021-12-31'));
        $task3->setCompleted(false);

        $manager->persist($task3);


        $manager->flush();
    }

    public function getDependencies()
    {

    }
}
