<?php

namespace App\Tests\Service;

use App\Service\EmailSender;
use App\ValueObject\ContactForm;
use PHPUnit\Framework\TestCase;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Mailer\Exception\TransportException;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Mailer\MailerInterface;

class EmailSenderTest extends TestCase
{

    public function testSendContactUsForm()
    {
        $contactForm = new ContactForm();
        $contactForm->email = 'test@mail.ru';
        $contactForm->name = 'Igor';
        $contactForm->subject = 'Saying hello';
        $contactForm->message = 'Hello';

        $email = new TemplatedEmail();

        $email
            ->to('roman.ksv@mail.ru')
            ->from('roman-ksv@mail.ru')
            ->subject('You got new message!')
            ->htmlTemplate('emails/contact_form.html.twig')
            ->context([
                'name' => $contactForm->name,
                'customer_email' => $contactForm->email,
                'subject' => $contactForm->subject,
                'message' => $contactForm->message,
            ]);

        $mailer = $this->createMock(MailerInterface::class);
        $mailer->expects($this->once())
            ->method('send')
            ->with($email);

        $emailSender = new EmailSender($mailer);
        $emailSender->sendContactUsForm($contactForm);

    }

    public function testSendContactUsFormWithException()
    {
        $this->expectException(TransportExceptionInterface::class);

        $contactForm = new ContactForm();
        $contactForm->email = 'test@mail.ru';
        $contactForm->name = 'Igor';
        $contactForm->subject = 'Saying hello';
        $contactForm->message = 'Hello';

        $email = new TemplatedEmail();

        $email
            ->to('roman.ksv@mail.ru')
            ->from('roman-ksv@mail.ru')
            ->subject('You got new message!')
            ->htmlTemplate('emails/contact_form.html.twig')
            ->context([
                'name' => $contactForm->name,
                'customer_email' => $contactForm->email,
                'subject' => $contactForm->subject,
                'message' => $contactForm->message,
            ]);

        $mailer = $this->createMock(MailerInterface::class);
        $mailer->expects($this->once())
            ->method('send')
            ->with($email)
            ->willThrowException(new TransportException('Failed to send request'));

        $emailSender = new EmailSender($mailer);
        $emailSender->sendContactUsForm($contactForm);
    }
}
