<?php

namespace App\Http\Controllers\Stream;

use App\Contracts\StreamContract;
use App\Http\Controllers\Controller;
use App\Http\Requests\StreamStoreRequest;
use Illuminate\Support\Facades\{Auth, Facade};

/**
 * Class StreamController
 * @package App\Http\Controllers
 */
class StreamController extends Controller {
    /**
     * @var StreamContract
     */
    private StreamContract $objStreamServices;

    /**
     * StreamController constructor.
     * @param StreamContract $objStreamServices
     */
    public function __construct(StreamContract $objStreamServices) {
        $this->objStreamServices = $objStreamServices;
    }

    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function mainPage() {
        /** @var \App\Models\User $objUser */
        $objUser = Auth::user();
        $data = $this->objStreamServices->getAll($objUser);

        return view("stream.main", ["data" => $data]);
    }

    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function createStreamPage() {
        return view("stream.create");
    }

    /**
     * @param StreamStoreRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function storeStreamInfo(StreamStoreRequest $request) {
        /** @var \App\Models\User $objUser */
        $objUser = Auth::user();

        if ($this->objStreamServices->createStream($request->only(['name', 'description', 'stream_preview']), $objUser) == true) {
            return redirect()->route("stream.index")->with("message", "Stream Created");
        }

        return redirect()->route("stream.index")->withErrors(['error' => 'Something went wrong']);
    }

    /**
     * @param string $stream_id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function showStreamPage(string $stream_id) {
        /** @var \App\Models\User $objUser */
        $objUser = Auth::user();

        $data = $this->objStreamServices->showStream($stream_id, $objUser);

        return view("stream.show", ["data" => $data]);
    }
}
