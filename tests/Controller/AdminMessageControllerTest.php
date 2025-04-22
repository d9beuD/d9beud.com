<?php

namespace App\Tests\Controller;

use App\Entity\Message;
use DateTimeImmutable;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

final class MessageControllerTest extends WebTestCase
{
    private KernelBrowser $client;
    private EntityManagerInterface $manager;
    private EntityRepository $messageRepository;
    private string $path = '/admin/message/';

    protected function setUp(): void
    {
        $this->client = static::createClient();
        $this->manager = static::getContainer()->get('doctrine')->getManager();
        $this->messageRepository = $this->manager->getRepository(Message::class);

        foreach ($this->messageRepository->findAll() as $object) {
            $this->manager->remove($object);
        }

        $this->manager->flush();
    }

    public function testIndex(): void
    {
        $this->client->followRedirects();
        $crawler = $this->client->request('GET', $this->path);

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('Messages reçus');

        // Use the $crawler to perform additional assertions e.g.
        // self::assertSame('Some text on the page', $crawler->filter('.p')->first());
    }

    public function testShow(): void
    {
        $this->markTestIncomplete();
        $fixture = new Message();
        $fixture->setEmail('test@example.com');
        $fixture->setContent('My Content');
        $fixture->setCreatedAt(new DateTimeImmutable());
        $fixture->setName('Example Name');

        $this->manager->persist($fixture);
        $this->manager->flush();

        $crawler = $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('Message');

        // Use assertions to check that the properties are properly displayed.
        $pageContent = $crawler->filter('body')->first();
        self::assertContains($fixture->getEmail(), $pageContent);
        self::assertContains($fixture->getContent(), $pageContent);
        self::assertContains($fixture->getName(), $pageContent);
    }

    // public function testEdit(): void
    // {
    //     $this->markTestIncomplete();
    //     $fixture = new Message();
    //     $fixture->setEmail('Value');
    //     $fixture->setContent('Value');
    //     $fixture->setCreatedAt('Value');
    //     $fixture->setName('Value');

    //     $this->manager->persist($fixture);
    //     $this->manager->flush();

    //     $this->client->request('GET', sprintf('%s%s/edit', $this->path, $fixture->getId()));

    //     $this->client->submitForm('Update', [
    //         'message[email]' => 'Something New',
    //         'message[content]' => 'Something New',
    //         'message[createdAt]' => 'Something New',
    //         'message[name]' => 'Something New',
    //     ]);

    //     self::assertResponseRedirects('/message/');

    //     $fixture = $this->messageRepository->findAll();

    //     self::assertSame('Something New', $fixture[0]->getEmail());
    //     self::assertSame('Something New', $fixture[0]->getContent());
    //     self::assertSame('Something New', $fixture[0]->getCreatedAt());
    //     self::assertSame('Something New', $fixture[0]->getName());
    // }

    // public function testRemove(): void
    // {
    //     $this->markTestIncomplete();
    //     $fixture = new Message();
    //     $fixture->setEmail('Value');
    //     $fixture->setContent('Value');
    //     $fixture->setCreatedAt('Value');
    //     $fixture->setName('Value');

    //     $this->manager->persist($fixture);
    //     $this->manager->flush();

    //     $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));
    //     $this->client->submitForm('Delete');

    //     self::assertResponseRedirects('/message/');
    //     self::assertSame(0, $this->messageRepository->count([]));
    // }
}
