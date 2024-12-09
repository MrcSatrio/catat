<?php

namespace App\Filters;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;

class RoleFilter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        $session = session();
        
        if (!$session->get('id_user')) {
            return redirect()->to('/');
        } else {
            $role = $session->get('id_role');
            $uriPath = $request->getUri()->getPath();  // Access URI using getUri() method
            
            if ($role == 1 && strpos($uriPath, 'admin') === false) {
                return redirect()->to(base_url('admin/dashboard'));
            } elseif ($role == 2 && strpos($uriPath, 'user') === false) {
                return redirect()->to(base_url('user/dashboard'));
            }
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // Do something here
    }
}
