<?php

namespace Modules\Notify\Events\Handlers;

use Maatwebsite\Sidebar\Group;
use Maatwebsite\Sidebar\Item;
use Maatwebsite\Sidebar\Menu;
use Modules\Core\Events\BuildingSidebar;
use Modules\User\Contracts\Authentication;

class RegisterNotifySidebar implements \Maatwebsite\Sidebar\SidebarExtender
{
    /**
     * @var Authentication
     */
    protected $auth;

    /**
     * @param Authentication $auth
     *
     * @internal param Guard $guard
     */
    public function __construct(Authentication $auth)
    {
        $this->auth = $auth;
    }

    public function handle(BuildingSidebar $sidebar)
    {
        $sidebar->add($this->extendWith($sidebar->getMenu()));
    }

    /**
     * @param Menu $menu
     * @return Menu
     */
    public function extendWith(Menu $menu)
    {
        $menu->group(trans('core::sidebar.content'), function (Group $group) {
//            $group->item(trans('notify::notifies.title.notifies'), function (Item $item) {
//                $item->icon('fa fa-copy');
//                $item->weight(10);
//                $item->authorize(
//                     /* append */
//                );
//                $item->item(trans('notify::notifies.title.notifies'), function (Item $item) {
//                    $item->icon('fa fa-copy');
//                    $item->weight(0);
//                    $item->append('admin.notify.notify.create');
//                    $item->route('admin.notify.notify.index');
//                    $item->authorize(
//                        $this->auth->hasAccess('notify.notifies.index')
//                    );
//                });
//// append
//
//            });
        });

        return $menu;
    }
}
