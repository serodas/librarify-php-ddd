<?php

declare(strict_types=1);

namespace MyLibrary\Librarify\Books\Application\Create;

use MyLibrary\Librarify\Books\Domain\BookDescription;
use MyLibrary\Librarify\Books\Domain\BookScore;
use MyLibrary\Librarify\Books\Domain\BookTitle;
use MyLibrary\Librarify\Shared\Domain\Books\BookId;
use MyLibrary\Shared\Domain\Bus\Command\CommandHandler;

final class CreateBookCommandHandler implements CommandHandler
{
    public function __construct(private readonly BookCreator $creator)
    {
    }

    public function __invoke(CreateBookCommand $command): void
    {
        $id             = new BookId($command->id());
        $title          = new BookTitle($command->title());
        $description    = new BookDescription($command->description());
        $score          = new BookScore($command->score());

        $this->creator->__invoke($id, $title, $description, $score, $command->authors(), $command->categories());
    }
}
