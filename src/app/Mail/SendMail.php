<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class SendMail extends Mailable
{
    use Queueable, SerializesModels;

	protected $text;
	protected $item;
	protected $price;
	protected $commission_rate;
	protected $sales_proceeds;
	protected $transaction_partner;
	protected $review;

    /**
     * Create a new message instance.
     */
    public function __construct(private $name, $exhibition_item, $transaction_partner, $review)
    {
		$this->item = sprintf('%s', $exhibition_item->name);
		$this->price = sprintf('%s', $exhibition_item->price);
		$this->commission_rate = sprintf('%s', intval(floor($exhibition_item->price * 0.11)));
		$this->sales_proceeds = sprintf('%s', $exhibition_item->price - intval(floor($exhibition_item->price * 0.11)));
		$this->transaction_partner = sprintf('%s', $transaction_partner);
		$this->review = sprintf('%s', $review);
		$this->text = sprintf('%sさんの評価をお願い致します。', $name);
    }

	/**
	 * Build the message.
	 *
	 * @return $this
	 */
	public function build()
	{
		return $this->view('mail.mail')
			->with([
				'text'                => $this->text,
				'item'                => $this->item,
				'price'               => $this->price,
				'commission_rate'     => $this->commission_rate,
				'sales_proceeds'      => $this->sales_proceeds,
				'transaction_partner' => $this->transaction_partner,
				'review'              => $this->review,
			]);
	}

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
			from: new Address('info@coachtech.com', '運営'),
			subject: '取引完了通知',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content();
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
