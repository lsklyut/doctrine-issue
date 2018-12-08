<?php

use Doctrine\ORM\EntityManager;
use LeoDoctrineBug\Entity\Book;
use LeoDoctrineBug\Entity\Gadget;
use LeoDoctrineBug\Entity\Student;

const STARTING_NUMBER_OF_GADGETS = 3;
require 'bootstrap.php';

const STARTING_NUMBER_OF_BOOKS = 5;

/**
 * @param EntityManager $entityManager
 */
function testScenarioCreatesDuplicates(EntityManager $entityManager)
{
    $student = setUpStudent($entityManager);

    // At this point we have a student with 5 books and 3 gadgets.

    foreach ($student->getBooks() as $book) {
        $entityManager->remove($book);
        $entityManager->flush($book);
    }

    setUpBooksForStudent($entityManager, $student);

    foreach ($student->getGadgets() as $gadget) {
        $entityManager->remove($gadget);
        $entityManager->flush($gadget);
    }

    setUpGadgetsForStudent($entityManager, $student);

    $entityManager->flush();

    // At this point we have a student with 10 books and 6 gadgets.

    $wereBooksDuplicated = count($student->getBooks()) == 2 * STARTING_NUMBER_OF_BOOKS;

    print "Books were " . ($wereBooksDuplicated ? '' : 'not ') . 'duplicated.' . PHP_EOL;

    $wereGadgetsDuplicated = count($student->getGadgets()) == 2 * STARTING_NUMBER_OF_GADGETS;

    print "Gadgets were " . ($wereGadgetsDuplicated ? '' : 'not ') . 'duplicated.' . PHP_EOL;
}

/**
 * @param EntityManager $entityManager
 * @return Student
 */
function setUpStudent(EntityManager $entityManager)
{
    $student = new Student();
    $student->setName('Leo');

    $entityManager->persist($student);

    setUpBooksForStudent($entityManager, $student);
    setUpGadgetsForStudent($entityManager, $student);

    $entityManager->flush();
    return $student;
}

/**
 * @param EntityManager $entityManager
 * @param Student $student
 */
function setUpBooksForStudent(EntityManager $entityManager, Student $student)
{
    foreach (range(1, STARTING_NUMBER_OF_BOOKS) as $i) {
        $book = new Book();
        $book->setName("Book {$i}");
        $book->setStudent($student);
        $student->addBook($book);

        $entityManager->persist($book);
        $entityManager->flush($book);
    }
}

/**
 * @param EntityManager $entityManager
 * @param Student $student
 */
function setUpGadgetsForStudent(EntityManager $entityManager, Student $student)
{
    $gadgets = ['laptop', 'phone', 'smartwatch'];

    foreach ($gadgets as $gadgetName) {
        $gadget = new Gadget();
        $gadget->setName($gadgetName);

        $gadget->setStudent($student);
        $student->addGadget($gadget);

        $entityManager->persist($gadget);
        $entityManager->flush($gadget);
    }
}

testScenarioCreatesDuplicates($entityManager);