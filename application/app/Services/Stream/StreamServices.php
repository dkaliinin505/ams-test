<?php

namespace App\Services\Stream;

use App\Models\Stream;
use App\Contracts\StreamContract;
use App\Models\User;
use App\Services\Token\TokenServices;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\{Http, File, Auth};

class StreamServices implements StreamContract {

    /**
     * @var TokenServices
     */
    private TokenServices $objTokenServices;

    /**
     * StreamServices constructor.
     * @param TokenServices $objTokenServices
     */
    public function __construct(TokenServices $objTokenServices) {
        $this->objTokenServices = $objTokenServices;
    }

    /**
     * @param \App\Models\User $objUser
     * @return array
     */
    public function getAll(User $objUser): array {
        $data = Http::withHeaders([
            "Authorization" => $this->objTokenServices->get_token($objUser->id),
        ])->get(config("stream.api_url") . "/LiveApp/rest/v2/broadcasts/list/0/25");

        return json_decode($data->getBody());
    }

    /**
     * @param array $request
     * @param \App\Models\User $objUser
     * @return bool
     */
    public function createStream(array $request, User $objUser): bool {
        $data = Http::withHeaders([
            "Authorization" => $this->objTokenServices->get_token($objUser->id),
        ])->post(config("stream.api_url") . "/LiveApp/rest/v2/broadcasts/create", [
            "name"        => $request["name"],
            "description" => $request["description"],
            "username"    => $objUser->name,
        ]);

        $data = json_decode($data->getBody());

        if (is_null($data)) {
            return false;
        }

        $stream = Stream::create([
            "stream_id" => $data->streamId,
            "img_path"  => "previews/" . $data->streamId,
        ]);

        Storage::disk("public")->put($stream->img_path . ".jpg", File::get($request["stream_preview"]));

        return true;

    }

    /**
     * @param string $stream_id
     * @param \App\Models\User $objUser
     * @return object
     */
    public function showStream(string $stream_id, User $objUser): object {
        $data = Http::withHeaders([
            "Authorization" => $this->objTokenServices->get_token($objUser->id),
        ])->get(config("stream.api_url") . "/LiveApp/rest/v2/broadcasts/" . $stream_id);

        return json_decode($data->getBody());
    }
}
