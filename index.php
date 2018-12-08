<?php

use LeoDoctrineBug\Entity\Book;
use LeoDoctrineBug\Entity\Gadget;
use LeoDoctrineBug\Entity\Student;

require 'bootstrap.php';

$student = new Student();
$student->setName('Leo');

$entityManager->persist($student);
$entityManager->flush();

foreach (range(1, 5) as $i) {
    $book = new Book();
    $book->setName("Book {$i}");
    $book->setStudent($student);
    $student->addBook($book);
}

$gadgets = ['laptop', 'phone', 'smartwatch'];

foreach ($gadgets as $gadgetName) {
    $gadget = new Gadget();
    $gadget->setName($gadgetName);

    $gadget->setStudent($student);
    $student->addGadget($gadget);

    $entityManager->persist($gadget);
    $entityManager->flush($gadget);
}

$entityManager->flush();