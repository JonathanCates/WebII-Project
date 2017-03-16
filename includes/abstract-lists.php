<?php
    abstract class lists implements Serializable
    {
        private $list;
        
        abstract protected function getSql($id);
        
        public function __construct()
        {
            $this->list = array();
        }
        
        public function update($id, $index)
        {
            $this->list[$index] = $id;
        }
        
        public function add($id, $cart)
        {
            if($cart == true)
            {
                if(!empty($this->list))
                {
                    $count = count($this->list);
                    $updated = false;
                    for($i = 0; $i <= $count; $i++)
                    {
                        if($id['id'] == $this->list[$i]['id'])
                        {
                            $this->update($id, $i);
                            $updated = true;
                        }
                    }
                    if(!$updated)
                    {
                        $this->list[$count] = $id;
                    }
                }
                else
                {
                    $this->list[0] = $id;
                }
            }
            else if(!in_array($id, $this->list))
            {
                $this->list[] = $id;
            }
        }
        
        public function remove($id,$cart)
        {
            if($cart == true)
            {
                if(in_array($id, $this->list))
                {
                    $remove = array_search($id,$this->list);
                    unset($this->list[$remove]);
                    $this->list = array_values($this->list);
                }
            }
            else
            {
                if(!in_array($id, $this->list))
                {
                    $remove = array_search($id,$this->list);
                    unset($this->list[$remove]);
                    $this->list = array_values($this->list);
                }
            }
        }
        
        public function removeAll()
        {
            $this->list = array();
        }
        
        public function getList()
        {
            return $this->list;
        }
        
        public function serialize()
        {
            return serialize($this->list);
        }
        
        public function unserialize($data)
        {
            $this->list = unserialize($data);
        }
    }

?>