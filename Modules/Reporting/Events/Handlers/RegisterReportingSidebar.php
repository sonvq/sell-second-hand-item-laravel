<?php

namespace Modules\Reporting\Events\Handlers;

use Maatwebsite\Sidebar\Group;
use Maatwebsite\Sidebar\Item;
use Maatwebsite\Sidebar\Menu;
use Modules\Core\Events\BuildingSidebar;
use Modules\User\Contracts\Authentication;

class RegisterReportingSidebar implements \Maatwebsite\Sidebar\SidebarExtender
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
            $group->item(trans('reporting::reportings.title.reportings'), function (Item $item) {
                $item->icon('fa fa-copy');
                $item->weight(10);
                $item->authorize(
                     /* append */
                );
                $item->item(trans('reporting::reportings.title.reportings'), function (Item $item) {
                    $item->icon('fa fa-copy');
                    $item->weight(0);
//                    $item->append('admin.reporting.reporting.create');
                    $item->route('admin.reporting.reporting.index');
                    $item->authorize(
                        $this->auth->hasAccess('reporting.reportings.index')
                    );
                });
// append
                $item->item(trans('reporting::reporting-reasons.title.reporting reasons'), function (Item $item) {
                    $item->icon('fa fa-copy');
                    $item->weight(0);
                    $item->append('admin.reporting.reporting-reasons.create');
                    $item->route('admin.reporting.reporting-reasons.index');
                    $item->authorize(
                        $this->auth->hasAccess('reporting.reporting-reasons.index')
                    );
                });

            });
        });

        return $menu;
    }
}
