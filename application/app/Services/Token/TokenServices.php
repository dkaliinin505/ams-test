<?php


namespace App\Services\Token;

use App\Models\Token;
use DateTimeImmutable;
use Lcobucci\JWT\Configuration;
use App\Contracts\TokenContract;
use Lcobucci\JWT\Signer\Hmac\Sha256;
use Lcobucci\JWT\Signer\Key\InMemory;

class TokenServices implements TokenContract {
    /**
     * @var Token
     */
    private $token_model;

    /**
     * TokenServices constructor.
     */
    public function __construct() {
        $this->token_model = new Token();
    }

    /**
     * @param $id
     * @return string
     */
    public function make_token(int $id): string {
        $config = Configuration::forSymmetricSigner(
            new Sha256(),
            InMemory::plainText(config("stream.api_secret"))
        );
        assert($config instanceof Configuration);
        $now = new DateTimeImmutable();
        $token = $config->builder()
                        ->expiresAt($now->modify("+1 hour"))
                        ->withHeader("alg", "HS256")
                        ->withHeader("typ", "JWT")
                        ->getToken($config->signer(), $config->signingKey());

        $this->token_model->user_id = $id;
        $this->token_model->token = $token->toString();
        $this->token_model->token_type = "JWT";
        $this->token_model->expires_at = $now->modify("+5 hour");
        $this->token_model->save();

        return $token->toString();
    }

    /**
     * @param int $id
     * @return string
     */
    public function get_token(int $id): string {
        return $this->token_model->where("user_id", $id)->value("token");
    }
}
