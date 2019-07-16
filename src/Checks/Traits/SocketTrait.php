<?php
namespace Health\Checks\Traits;

trait SocketTrait
{

    /**
     * Socket resource
     *
     * @var resource
     */
    protected $resource = null;

    /**
     *
     * @param int $domain
     * @param int $type
     * @param int $protocol
     *
     * @return resource
     */
    protected function create($domain, $type, $protocol)
    {
        $this->resource = @socket_create($domain, $type, $protocol);

        return $this->resource;
    }

    /**
     * Connect to address
     *
     * @param string $address
     * @param int|null $timeout
     * @return boolean
     */
    protected function connect($address)
    {
        if (filter_var($address, FILTER_VALIDATE_IP) || preg_match("/:/", $address)) {

            if (filter_var($address, FILTER_VALIDATE_IP, FILTER_FLAG_IPV6)) {
                $address = 'http://' . $address;
            }

            $url = parse_url($address);

            $host = $url['host'] ?? null;
            $port = $url['port'] ?? null;
        } else {
            // For UNIX sockets
            $host = $address;
            $port = null;
        }

        return @socket_connect($this->resource, $host, $port);
    }

    /**
     * Close SocketTrait
     */
    protected function close()
    {
        socket_close($this->resource);
    }

    /**
     *
     * @return array
     */
    protected function getError()
    {
        $code = socket_last_error();
        $msg = socket_strerror($code);

        return [
            'code' => $code,
            'message' => $msg
        ];
    }
}