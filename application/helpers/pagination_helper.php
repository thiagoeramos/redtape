<?php

    function pagination_search($per_page = 0, $total_rows = 0, $uri_segment = 0, $segment_array = array(), $base_url = '', $config = null)
    {
        
        
        $config['per_page'] = $per_page;
        $config['full_tag_open']	= '<div class="pagination">';
        $config['full_tag_close']	= '</div>';
        $config['first_link']		= 'Primeira';
        $config['last_link']		= 'Última';
        $config['first_tag_open']	= '<a>';
        $config['first_tag_close']	= '</a>';
        $config['cur_tag_open']		= '<a class="pagination_active">';
        $config['cur_tag_close']	= '</a>';
        $config['total_rows'] =  $total_rows;
        $config['uri_segment'] = $uri_segment;
        $config['base_url'] = base_url().$base_url;
        $config['num_links']		= 5;
        $config['first_url'] = rtrim($config['base_url'],'/').'/'.$config['base_64'];
        $config['suffix'] = '/'.$config['base_64'];
        $config['use_page_numbers'] = TRUE;        
        $config['display_pages'] = TRUE;
         
         
         $config['search_args']=json_decode(utf8_encode(urldecode(base64_decode(@$config['base_64']))), true);
         
        if(!empty($config['base_64']) && base64_decode($config['base_64'], true))
        {            
            $config['search_args'] = json_decode(utf8_encode(urldecode(base64_decode($config['base_64']))), true);
        }
        
        return $config;
    }
    
    function pagination_args($per_page = 0, $uri_segment = 0, $segment_array = array(), $config = null)
    {
        $config['per_page'] = $per_page;
        $config['uri_segment'] = $uri_segment;
        $config['search_args'] = array();
        $config['base_64'] = '';
         $config['num_links']		= 10;
        @$config['page_now'] = (int)(($segment_array[$config['uri_segment']]*$config['per_page'])-$config['per_page']);
        $config['page_now'] = ($config['page_now']<0)?0:$config['page_now'];
       
    
        $config['search_args']=json_decode(utf8_encode(urldecode(base64_decode(@$segment_array[$config['uri_segment']]))), true);
    
        if(base64_decode(@$segment_array[$config['uri_segment']], true) && json_decode(urldecode(base64_decode(@$segment_array[$config['uri_segment']]))))
        {
            $config['base_64'] = $segment_array[$config['uri_segment']]; 
        }
        elseif(base64_decode(@$segment_array[$config['uri_segment']+1], true) && json_decode(urldecode(base64_decode(@$segment_array[$config['uri_segment']+1]))))
        {
            $config['base_64'] = $segment_array[$config['uri_segment']+1]; 
        }
        
        if(!empty($config['base_64']) && base64_decode($config['base_64'], true))
        {            
            $config['search_args'] = json_decode(utf8_encode(urldecode(base64_decode($config['base_64']))), true);
        }
        
        return $config;
    }