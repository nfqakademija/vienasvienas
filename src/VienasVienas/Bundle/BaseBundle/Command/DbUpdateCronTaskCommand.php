<?php

namespace VienasVienas\Bundle\BaseBundle\Command;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;

/**
 * Class DbUpdateCronTaskCommand Cron task for clearing database from inactive reservations.
 *
 * @package VienasVienas\Bundle\BaseBundle\Command
 */
class DbUpdateCronTaskCommand extends ContainerAwareCommand
{
    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this
            ->setName('crontask:database:clear')
            ->setDescription('Cron task for clearing database from inactive reservations');
    }

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $output->writeln('<comment>Running Cron Task...</comment>');

        $em = $this->getContainer()->get('doctrine.orm.entity_manager');
        $orders = $em->getRepository('BaseBundle:Order')->findOldReservations(new \DateTime('now'));

        if ($orders == null) {
            $output->writeln('Nothing to clear!');
        }
        foreach ($orders as $order) {
            $order->setToken(null);
            $order->setReservationDate(null);
            $order->setStatus('done');
            $em->flush();

            $output->writeln('Database cleared!');
        }

        $reservations = $em->getRepository('BaseBundle:Order')->findByStatus('reserved');

        if ($reservations == null) {
            $output->writeln('There is no reservations!');
        }

        foreach ($reservations as $reservation) {
            $book = $reservation->getBook();
            $bookQuantity = $book->getQuantity();
            $tokenQuantity = $em->getRepository('BaseBundle:Order')->countTokens($book);

            $iterator = $bookQuantity - $tokenQuantity;

            for ($i = 0; $i < $iterator; $i++) {
                if ($reservation->getToken() == null) {
                    $this->getContainer()->get('token.setter')->setTokenToUser($book);
                    $output->writeln('Email sended!');
                }
            }
        }
    }
}
