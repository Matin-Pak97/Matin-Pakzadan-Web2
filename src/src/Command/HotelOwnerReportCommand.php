<?php

namespace App\Command;

use App\Repository\HotelRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Helper\Table;
use Symfony\Component\Console\Output\BufferedOutput;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(
    name: 'app:hotel-owner:report',
    description: 'A Command for make a report of hotels',
)]
class HotelOwnerReportCommand extends Command
{
    protected static $defaultName = 'app:hotel:report';
    protected static $defaultDescription = 'A Command for make a report of hotels';

    /** @var HotelRepository */
    private HotelRepository $hotelRepository;

    /** @var Filesystem */
    private Filesystem $filesystem;

    /**
     * PriceUpdateCommand constructor.
     * @param HotelRepository $hotelRepository
     * @param Filesystem $filesystem
     * @param string|null $name
     */
    public function __construct(
        HotelRepository $hotelRepository,
        Filesystem $filesystem,
        string $name = null
    )
    {
        parent::__construct($name);

        $this->hotelRepository = $hotelRepository;
        $this->filesystem = $filesystem;
    }

    protected function configure(): void
    {
        $this
            ->setDescription(self::$defaultDescription);
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        $result = $this->hotelRepository->createQueryBuilder("h")
            ->innerJoin("h.createdBy", "user")
            ->select("user.email as ownerEmail")
            ->addSelect("h.id as id")
            ->addSelect("h.name as name")
            ->addSelect("h.address as address")
            ->where("user.roles")
            ->where('user.roles LIKE :role')
                ->setParameter('role', '%HOTEL_OWNER%')
            ->getQuery()
            ->getArrayResult();

        $buffered = new BufferedOutput();
        $table = new Table($buffered);
        $table->setHeaders(["Owner Email", "ID", "Name", "Address"]);
        $table->setRows($result);
        $table->setStyle("box-double");
        $table->render();

        $this->filesystem->appendToFile("/var/www/html/var/report.txt", $buffered->fetch());

        $io->success('You have a new command! Now make it your own! Pass --help to see your options.');
        return Command::SUCCESS;
    }
}
