<?php


namespace App\Service;


use Symfony\Component\HttpFoundation\Request;

class DataTablesService
{
    /**
     * @var int
     */
    protected $draw;
    /**
     * @var int
     */
    protected $start;
    /**
     * @var int
     */
    protected $length;
    /**
     * @var array
     */
    protected $search;
    /**
     * @var array
     */
    protected $orders;
    /**
     * @var array
     */
    protected $columns;

    public function __construct()
    {

    }

    public function getRequest(Request $request)
    {
        $this->draw    = intval($request->request->get('draw'));
        $this->start   = intval($request->request->get('start'));
        $this->length  = intval($request->request->get('length'));
        $this->search  = $request->request->get('search');
        $this->orders  = $request->request->get('order');
        $this->columns = $request->request->get('columns');

//        dd($this->draw, $this->start, $this->length, $this->search, $this->orders, $this->columns);

        // Orders
        foreach ($this->orders as $key => $order) {
            // Orders does not contain the name of the column, but its number,
            // so add the name so we can handle it just like the $columns array
            $this->orders[$key]['name'] = $this->columns[$order['column']]['name'];
        }
    }

    /**
     * @return int
     */
    public function getDraw(): int
    {
        return $this->draw;
    }

    /**
     * @return int
     */
    public function getStart(): int
    {
        return $this->start;
    }

    /**
     * @return int
     */
    public function getLength(): int
    {
        return $this->length;
    }

    /**
     * @return array
     */
    public function getSearch(): array
    {
        return $this->search;
    }

    /**
     * @return array
     */
    public function getOrders(): array
    {
        return $this->orders;
    }

    /**
     * @return array
     */
    public function getColumns(): array
    {
        return $this->columns;
    }

}