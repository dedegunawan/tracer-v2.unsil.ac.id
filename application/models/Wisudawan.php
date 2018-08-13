<?php
/**
 *
 */

class Wisudawan
{
    var $ci;
    var $urlApi;
    var $app_id;
    var $data;
    function __construct()
    {
        $this->ci = get_instance();
        $this->ci->load->config('application');
        $this->urlApi = $this->ci->config->item('url_api');
        $this->app_id = $this->ci->config->item('app_id');
        $this->file_location = FCPATH."abc/wisudawan.cdrf";

    }
    public function getLulusan($prodi='', $Angkatan='') {
        if (!($this->data instanceof Illuminate\Support\Collection)) {
            $this->requestObject();
        }
        $dataResult = $this->data;
        if ($prodi) {
            $dataResult = $dataResult->where('ProdiID', (string)$prodi);
        }
        if ($Angkatan) {
            $dataResult = $dataResult->where('Angkatan', (string)$Angkatan);
        }
        return $dataResult;
    }
    public function requestObject()
    {

        if (
            !file_exists($this->file_location)
            ||
            filemtime($this->file_location)+(3600*24*30) < time()
        ) {
            $client = new GuzzleHttp\Client();
            $res = $client->request('GET', $this->urlApi."/lulusan", ['query' => ['app_id' => $this->app_id]]);
            file_put_contents($this->file_location, $res->getBody()->getContents());

        }
        $contents = file_get_contents($this->file_location);
        $this->data = collect(json_decode($contents));
        return $this->data;
    }

}
