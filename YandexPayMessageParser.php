<?php

/**
 * Class YandexPayMessageParser
 */
class YandexPayMessageParser
{
    /**
     * @var mixed
     */
    private $message;

    /**
     * @var string
     */
    private $code;

    /**
     * @var mixed
     */
    private $amount;

    /**
     * @var mixed
     */
    private $walletNumber;

    /**
     * YandexPayMessageParser constructor.
     * @param string $message
     * @throws Exception
     */
    public function __construct(string $message)
    {
        $this->message = $message;
        $this->code = $this->parseCode();
        $this->amount = $this->parseAmount();
        $this->walletNumber = $this->parseWalletNumber();
    }

    /**
     * @return array
     */
    public function getResult()
    {
        return [
            'code' => $this->code,
            'amount' => $this->amount,
            'walletNumber' => $this->walletNumber,
        ];
    }

    /**
     * @return string
     */
    private function parseCode(): string
    {
        $pattern = "/(?<!\d)(\d{4}|\d{5})\s/mU";

        return $this->parsePattern($pattern);
    }

    /**
     * @return string
     */
    private function parseAmount()
    {
        $pattern = "/\d+\,\d{2}/mU";

        return $this->parsePattern($pattern);
    }

    /**
     * @return string
     */
    private function parseWalletNumber()
    {
        $pattern = "/\d{15}/mU";

        return $this->parsePattern($pattern);
    }

    /**
     * @param string $pattern
     * @return string
     */
    private function parsePattern(string $pattern)
    {
        if (preg_match($pattern, $this->message, $matches) !== 1) {
            return '';
        }

        return $matches[0];
    }
}
