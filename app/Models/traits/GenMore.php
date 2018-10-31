<?php
    namespace App\Models\traits;


    trait GenMore
    {
        public function setMore($key, $val)
        {
            $more = $this->more;
            if (!$more) {
               $more = [];
            } else {
                $more = json_decode($more, true);
            }
            $more[$key] = $val;
            $this->more =  json_encode($more);

        }

        public function getMore($key, $default = [])
        {
            $more = $this->more;
            if (!$more) {
                return $default;
            }
            $more = json_decode($more, true);
            return isset($more[$key]) ? $more[$key] : $default;
        }
    }