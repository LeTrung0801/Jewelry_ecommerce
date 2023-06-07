<?php
namespace App\Http\Helpers;
class AppData{
    const accRole = [
        0 => 'admin',
        1 => 'quản lý',
        2 => 'nhân viên',
        3 => 'kế toán'
    ];

    const material = [
        1 => 'Vàng',
        2 => 'Bạc',
        3 => 'Bạch Kim',
    ];

    const order_status = [
        0 => 'Chờ xác nhận',
        1 => 'Đang giao',
        2 => 'Đã hoàn thành',
        3 => 'Đã hủy',
    ];

    const defaultPaginate = 9;
    const admin_sidebar = [
		[
			'title' => 'Danh Mục',
			'route' => 'admin-category-list',
			'active_routes' => [
                'admin-category-list',
                'admin-category-create',
                'admin-category-edit'
            ],
			'childs' => '',
            'class' => ''
		],
        [
            'title' => 'Sản Phẩm',
            'route' => 'admin-product-list',
            'active_routes' => [
                'admin-product-list',
                'admin-product-create',
                'admin-product-edit'
            ],
            'childs' => '',
            'class' => ''
        ],
        [
            'title' => 'Đơn Hàng',
            'route' => '',
            'active_routes' => [],
            'childs' => '',
            'class' => [
                [
					'title' => 'Đang Xử Lý',
					'route' => 'admin-process-order-list',
					'active_routes' => [
						'admin-process-order-list',
						'admin-process-order-edit'
					],
					'childs' => '',
					'class' => ''
				],
                [
					'title' => 'Đã Hoàn Thành',
					'route' => 'admin-complete-order-list',
					'active_routes' => [
						'admin-complete-order-list',
						'admin-complete-order-edit'
					],
					'childs' => '',
					'class' => ''
				]
            ]
        ],
        [
            'title' => 'Tài Khoản',
            'route' => '',
            'active_routes' => [],
            'childs' => [
                [
					'title' => 'Khách Hàng',
					'route' => 'admin-customer-list',
					'active_routes' => [
						'admin-customer-list',
						'admin-customer-edit'
					],
					'childs' => '',
					'class' => ''
				],
                [
					'title' => 'Nhân Viên ',
					'route' => 'admin-account-list',
					'active_routes' => [
						'admin-account-list',
                        'admin-account-create',
						'admin-account-edit'
					],
					'childs' => '',
					'class' => ''
				],
            ],
            'class' => ''
        ]
	];
}
