<?php

use Doctrine\ORM\EntityManager;
use LeoDoctrineBug\Entity\Book;
use LeoDoctrineBug\Entity\Student;

require 'bootstrap.php';

const STARTING_NUMBER_OF_BOOKS = 5;

/**
 * @param EntityManager $entityManager
 */
function testScenarioCreatesDuplicates(EntityManager $entityManager)
{
    $student = setUpStudent($entityManager);

    $books = $student->getBooks();

    foreach ($books as $book) {
        // The entity we're removing needs to be removed from the 1-M collection it belongs to.
        // Otherwise, duplicates will be created
        $books->removeElement($book);

        $entityManager->remove($book);
        $entityManager->flush($book);
    }

    setUpBooksForStudent($entityManager, $student);

    $wereBooksDuplicated = count($books) == 2 * STARTING_NUMBER_OF_BOOKS;

    print "Books were " . ($wereBooksDuplicated ? '' : 'not ') . 'duplicated.' . PHP_EOL;
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

testScenarioCreatesDuplicates($entityManager);