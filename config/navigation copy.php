<?php

$menus =  [
     [
        'label' => 'Setup',
        'route' => null,
        'icon' => 'fas fa-cog',
        'access' => 'setup',
        'parent_id' => 0,
        'submenu' =>  [
            [
                'label' => 'Division',
                'route' => 'division.index',
            ],

            [
                'label' => 'License Type',
                'route' => 'licensetype.index',
            ],
            [
                'label' => 'District',
                'route' => 'district.index',
            ],
            [
                'label' => 'Upazila',
                'route' => 'upozilla.index',
            ],
            [
                'label' => 'Zone',
                'route' => 'zones.index',
            ],
            [
                'label' => 'Sub zones',
                'route' => 'subzones.index',
            ],
            [
                'label' => 'TJ Box',
                'route' => 'tjs.index',
            ],
            [
                'label' => 'Splitter',
                'route' => 'splitters.index',
            ],
            [
                'label' => 'Box',
                'route' => 'boxes.index',
            ],
            [
                'label' => 'PPP Profiles',
                'route' => 'm_p_p_p_profiles.index',
            ],
            [
                'label' => 'IP Pool',
                'route' => 'mpool.index',
            ],
            [
                'label' => 'Queue',
                'route' => 'queue.index',
            ],
            [
                'label' => 'Vlan',
                'route' => 'vlan.index',
            ],
            [
                'label' => 'Ip Address',
                'route' => 'ip_address.index',
            ],
            [
                'label' => 'Device',
                'route' => 'devices.index',
            ],
            [
                'label' => 'POP',
                'route' => 'pops.index',
            ],
            [
                'label' => 'Router',
                'route' => 'routers.index',
            ],
            [
                'label' => 'Connected Path',
                'route' => 'connected_path.index',
            ],
            // [
            //     'label' => 'Connection Type',
            //     'route' => 'connections.index',
            // ],
            // [
            //     'label' => 'Client Type',
            //     'route' => 'client_types.index',
            // ],
            // [
            //     'label' => 'Protocol Type',
            //     'route' => 'protocols.index',
            // ],
            // [
            //     'label' => 'Packages',
            //     'route' => 'packages2.index',
            // ],
            // [
            //     'label' => 'Package',
            //     'route' => 'userpackage.index',
            // ],
            // [
            //     'label' => 'Billing Status',
            //     'route' => 'billingstatus.index',
            // ],
            // [
            //     'label' => 'Payment Methods',
            //     'route' => 'payments.index',
            // ],
        ]
    ],


    // [
    //     'label' => 'Client',
    //     'route' => null,
    //     'icon' => 'fas fa-users',
    //     'parent_id' => 0,
    //     'submenu' => [
    //         // [
    //         //     'label' => 'New Connection',
    //         //     'route' => 'newconnection.index',
    //         // ],
    //         [
    //             'label' => 'PPPOE Customer',
    //             'route' => 'customers.index',
    //         ],
    //         [
    //             'label' => 'Static Customer',
    //             'route' => 'static_customers.index',
    //         ],
    //         [
    //             'label' => 'General Customer',
    //             'route' => 'general_customers.index',
    //         ],
    //         [
    //             'label' => 'Advance Billing',
    //             'route' => 'advancebilling.index',
    //         ],
    //         [
    //             'label' => 'Active Connection',
    //             'route' => 'activeconnections.index',
    //         ],
    //         [
    //             'label' => 'Import Customer',
    //             'route' => 'mikrotiklist.index',
    //         ],
    //     ]
    // ],

    // [
    //     'label' => 'Billing',
    //     'route' => null,
    //     'icon' => 'fas fa-money-bill',
    //     'parent_id' => 0,
    //     'submenu' => [
    //         [
    //             'label' => 'Pending List',
    //             'route' => 'billcollect.index',
    //         ],
    //         // [
    //         //     'label' => 'Confirm Bill',
    //         //     'route' => 'billconfirm.index',
    //         // ],
    //         [
    //             'label' => 'Collected List',
    //             'route' => 'billcollected.index',
    //         ],
    //         [
    //             'label' => 'Custom Bill',
    //             'route' => 'custombill.index',
    //         ],
    //         [
    //             'label' => 'Import Billings',
    //             'route' => 'imports.billings',
    //         ],
    //     ]
    // ],

    // [
    //     'label' => 'Mikrotik Server',
    //     'route' => null,
    //     'icon' => 'fab fa-servicestack',
    //     'parent_id' => 0,
    //     'submenu' => [
    //         [
    //             'label' => 'Server',
    //             'route' => 'mikrotikserver.index',
    //         ],
    //         // [
    //         //     'label' => 'Import Customer',
    //         //     'route' => 'mikrotiklist.index',
    //         // ],
    //     ]
    // ],

    // [
    //     'label' => 'Mac Client',
    //     'route' => null,
    //     'icon' => 'fa fa-users',
    //     'parent_id' => 0,
    //     'submenu' => [
    //         [
    //             'label' => 'Package',
    //             'route' => 'macpackage.index',
    //         ],
    //         [
    //             'label' => 'Tariff Config',
    //             'route' => 'mactariffconfig.index',
    //         ],
    //         [
    //             'label' => 'Add Mac Reseller',
    //             'route' => 'macreseller.create',
    //         ],
    //         [
    //             'label' => 'All Mac Client',
    //             'route' => 'macreseller.index',
    //         ],
    //         [
    //             'label' => 'Reseller Invoice',
    //             'route' => 'resellerFunding.index',
    //         ],
    //         [
    //             'label' => 'Reseller Fund',
    //             'route' => 'addresellerfund.index',
    //         ],
    //     ]
    // ],
    [
        'label' => 'Upgradtion List',
        'route' => null,
        'access' => 'crm',
        'icon' => 'fa fa-users',
        'parent_id' => 0,
        'submenu' => [
            [
                'label' => 'Upgradation Create',
                'route' => 'upgradation.create',
            ],

            [
                'label' => 'Upgradation',
                'route' => 'upgradation.index',
            ],

            [
                'label' => 'Sale head',
                'route' => 'upgradtion_salehead.index',
            ],

            [
                'label' => 'Billing',
                'route' => 'upgradtionlist-billing.index',
            ],

            [
                'label' => 'Level 3',
                'route' => 'upgradtionlist-level3.index',
            ],

            [
                'label' => 'Confirm Bill',
                'route' => 'upgradtion-confrim-billing.index',
            ],
        ]
    ],
    // [
    //     'label' => 'Downgradtion List',
    //     'route' => null,
    //     'access' => 'crm',
    //     'icon' => 'fa fa-users',
    //     'parent_id' => 0,
    //     'submenu' => [
    //         [
    //             'label' => 'Downgradtion Create',
    //             'route' => 'downgradtion.create',
    //         ],

    //         [
    //             'label' => 'Downgradtion',
    //             'route' => 'downgradtion.index',
    //         ],

    //         [
    //             'label' => 'Sale head',
    //             'route' => 'downgradtion-salehead.index',
    //         ],

    //         [
    //             'label' => 'Billing',
    //             'route' => 'downgradtion-billing.index',
    //         ],

    //         [
    //             'label' => 'Level 3',
    //             'route' => 'downgradtion-level3.index',
    //         ],

    //         [
    //             'label' => 'Confirm Bill',
    //             'route' => 'downgradtion-confrim-billing.index',
    //         ],
    //     ]
    // ],
     [
        'label' => 'Crm',
        'route' => null,
        'access' => 'crm',
        'icon' => 'fa fa-users',
        'parent_id' => 0,
        'submenu' => [
            [
                'label' => 'Lead',
                'route' => 'lead.index',
            ],
            [
                'label' => 'Revert List',
                'route' => 'reverts.index',
            ],
            [
                'label' => 'Meeting List',
                'route' => 'meeting.index',
            ],
            [
                'label' => 'Follow Up',
                'route' => 'followup.index',
            ],
            [
                'label' => 'Pending Customer',
                'route' => 'pending_customer.index',
            ],
            [
                'label' => 'Sales Approve',
                'route' => 'admin_approv.index',
            ],
            [
                'label' => 'Legal Approve',
                'route' => 'legal_approv.index',
            ],
            [
                'label' => 'Billing Approve',
                'route' => 'billing_approv.index',
            ],
            [
                'label' => 'Generate Billing',
                'route' => 'confirm_billing_approv.index',
            ],
        ]
    ],
     [
        'label' => 'Technology',
        'route' => null,
        'access' => 'crm',
        'icon' => 'fa fa-users',
        'parent_id' => 0,
        'submenu' => [
            [
                'label' => 'TX Planing',
                'route' => 'noc_approv.index',
            ],
            [
                'label' => 'Transmission',
                'route' => 'transmission_approv.index',
            ],
            [
                'label' => 'Level 1',
                'route' => 'level_1.index',
            ],
            [
                'label' => 'Level 2',
                'route' => 'level_2.index',
            ],
            [
                'label' => 'Level 3',
                'route' => 'level_3.index',
            ],
            [
                'label' => 'Level 4',
                'route' => 'noc2_approv.index',
            ],
        ]
    ],
      [
        'label' => 'Reseller',
        'route' => null,
        'access' => 'reseller',
        'icon' => 'fa fa-users',
        'parent_id' => 0,
        'submenu' =>  [
            [
                'label' => 'Item Cateory',
                'route' => 'itemcategory.index',
            ],
            [
                'label' => 'Item',
                'route' => 'items.index',
            ],
            [
                'label' => 'Reject',
                'route' => 'rejectbandwidthCustomers.index',
            ],
            [
                'label' => 'Clients',
                'route' => 'bandwidthCustomers.index',
            ],
            [
                'label' => 'Sale Invoice',
                'route' => 'bandwidthsaleinvoice.index',
            ],

            [
                'label' => 'Upgradation',
                'route' => 'upgradation.create',
            ],
            [
                'label' => 'Upgradation List',
                'route' => 'upgradation.index',
            ],
            [
                'label' => 'Downgrading',
                'route' => 'downgrading.create',
            ],
            [
                'label' => 'Downgrading List',
                'route' => 'downgrading.index',
            ],
            [
                'label' => 'Cap/Uncap',
                'route' => 'capuncap.create',
            ],
            [
                'label' => 'Cap/Uncap List',
                'route' => 'capuncap.index',
            ],
        ]
    ],
    [
        'label' => 'Upstream',
        'route' => null,
        'access' => 'upstream',
        'icon' => 'fas fa-industry',
        'parent_id' => 0,
        'submenu' => [
            [
                'label' => 'Item Cateory',
                'route' => 'itemcategory.index',
            ],
            [
                'label' => 'Item',
                'route' => 'items.index',
            ],
            [
                'label' => 'Providers',
                'route' => 'providers.index',
            ],
            [
                'label' => 'Purchase Bill',
                'route' => 'purchasebill.index',
            ],
        ]
    ],
    [
        'label' => 'Support & Ticketing',
        'route' => null,
        'access' => 'supportticket',
        'icon' => 'fas fa-ticket-alt',
        'parent_id' => 0,
        'submenu' => [
            [
                'label' => 'Support Category',
                'route' => 'supportcategory.index',
            ],
            [
                'label' => 'Client Support',
                'route' => 'supportticket.index',
            ],
            [
                'label' => 'Client Support',
                'route' => 'employee.index',
            ],
        ]
    ],
    [
        'label' => 'Accounting',
        'route' => null,
        'icon' => 'fas fa-calculator',
        'access' => 'accounting',
        'parent_id' => 0,
        'submenu' => [
            [
                'label' => 'Accounts Head',
                'route' => 'accounts.index',
            ],
            [
                'label' => 'Opening Balance',
                'route' => 'openingbalance.index',
            ],
            [
                'label' => 'Balance Transfer',
                'route' => 'balancetransfer.index',
            ],
            [
                'label' => 'Bill Transfer',
                'route' => 'billtransfer.index',
            ],
            [
                'label' => 'Supplier Ledger',
                'route' => 'supplier_ledger.index',
            ],
            [
                'label' => 'Reseller Payment',
                'route' => 'resellerFunding.paymentCreate',
            ],
        ]
    ],
    [
        'label' => 'HR & PAYROLL',
        'route' => null,
        'access' => 'hrpayroll',
        'icon' => 'fas fa-users-cog',
        'parent_id' => 0,
        'submenu' => [
            [
                'label' => 'Team',
                'route' => 'team.index',
            ],
            [
                'label' => 'Department',
                'route' => 'department.index',
            ],
            [
                'label' => 'Designation',
                'route' => 'designation.index',
            ],
            [
                'label' => 'Employee',
                'route' => 'employees.index',
            ],
            [
                'label' => 'Attendance Form',
                'route' => 'hrm.attendance.create',
            ],
            [
                'label' => 'Attendance Log',
                'route' => 'hrm.attendancelog.index',
            ],

            [
                'label' => 'Salary Sheet',
                'route' => 'hrm.salarysheetlog.index',
            ],
            [
                'label' => 'Leave Application',
                'route' => 'leaveApplication.index',
            ],

            [
                'label' => 'Leave Approve',
                'route' => 'leaveApplicationApprove.index',
            ],

            [
                'label' => 'Lone Application',
                'route' => 'loneApplication.index',
            ],

            [
                'label' => 'Lone Approve',
                'route' => 'loneApplicationApprove.index',
            ],
        ]
    ],

    //


    [
        'label' => 'Inventory Setup',
        'route' => null,
        'access' => 'inventorysetup',
        'icon' => 'fas fa-warehouse',
        'parent_id' => 0,
        'submenu' => [
            [
                'label' => 'All Products',
                'route' => 'products.index',
            ],
            [
                'label' => 'Create Products',
                'route' => 'products.create',
            ],
            [
                'label' => 'All Product Category',
                'route' => 'productCategory.index',
            ],
            [
                'label' => 'Create  Category',
                'route' => 'productCategory.create',
            ],

            [
                'label' => 'All Unit',
                'route' => 'units.index',
            ],
            [
                'label' => 'Create Unit',
                'route' => 'units.create',
            ],

            [
                'label' => 'All Brands',
                'route' => 'brands.index',
            ],
            [
                'label' => 'Create Brands',
                'route' => 'brands.create',
            ],

        ]
    ],
    [
        'label' => 'Inventory Management',
        'route' => null,
        'access' => 'inventoryman',
        'icon' => 'fas fa-boxes',
        'parent_id' => 0,
        'submenu' => [
            [
                'label' => 'Purchase Requisition',
                'route' => 'purchaseRequisition.index',
            ],
            [
                'label' => 'All Purchases',
                'route' => 'purchases.index',
            ],
            [
                'label' => 'Create Purchases',
                'route' => 'purchases.create',
            ],
            [
                'label' => 'Stock Details',
                'route' => 'purchases.stock.list',
            ],
            [
                'label' => 'All Stock Out',
                'route' => 'stockout.index',
            ],
            [
                'label' => 'Create Stock Out',
                'route' => 'stockout.create',
            ],


        ]
    ],
    [
        'label' => 'Supplier',
        'route' => null,
        'access' => 'supplier',
        'icon' => 'fa fa-users',
        'parent_id' => 0,
        'submenu' => [
            [
                'label' => 'All Supplier',
                'route' => 'suppliers.index',
            ],
            [
                'label' => 'Create Supplier',
                'route' => 'suppliers.create',
            ],
        ]
    ],
    ///
    [
        'label' => 'Income',
        'route' => null,
        'icon' => 'fas fa-wallet',
        'access' => 'income',
        'parent_id' => 0,
        'submenu' => [
            [
                'label' => 'Income Category',
                'route' => 'incomeCategory.index',
            ],
            [
                'label' => 'Daily Income',
                'route' => 'dailyIncome.index',
            ],
            // [
            //     'label' => 'Income History',
            //     'route' => 'incomeHistory.index',
            // ],
            // [
            //     'label' => 'Installation Fee',
            //     'route' => 'installationFee.index',
            // ],
        ]
    ],

    [
        'label' => 'Expense',
        'route' => null,
        'access' => 'expense',
        'icon' => 'fas fa-credit-card',
        'parent_id' => 0,
        'submenu' => [
            [
                'label' => 'Expense Category',
                'route' => 'expense_category.index',
            ],
            [
                'label' => 'Create Expense Category',
                'route' => 'expense_category.create',
            ],
            [
                'label' => 'Expense List',
                'route' => 'expenses.index',
            ],
            [
                'label' => 'Create Expense',
                'route' => 'expenses.create',
            ],
        ]
    ],
    [
        'label' => 'Asset Management',
        'route' => null,
        'access' => 'assetmanagement',
        'icon' => 'fas fa-tasks',
        'parent_id' => 0,
        'submenu' => [
            [
                'label' => 'Asset Category',
                'route' => 'assets.index',
            ],
            // [
            //     'label' => 'Asset Category Create',
            //     'route' => 'assets.create',
            // ],
            [
                'label' => 'Reason List',
                'route' => 'reasons.index',
            ],
            [
                'label' => 'Asset List',
                'route' => 'assetlist.index',
            ],
            [
                'label' => 'Destroy Items',
                'route' => 'destroyitems.index',
            ],
        ]
    ],

    [
        'label' => 'Reports',
        'route' => null,
        'access' => 'reports',
        'icon' => 'fas fa-border-none',
        'parent_id' => 0,
        'submenu' => [
            [
                'label' => 'BTRC',
                'route' => 'reports.btrc',
            ],
            [
                'label' => 'Discount',
                'route' => 'reports.discounts',
            ],
            [
                'label' => 'Bill Collect',
                'route' => 'reports.bill.index',
            ],
            [
                'label' => 'Mac Client',
                'route' => 'reports.mac.reseller',
            ],
            [
                'label' => 'Customer',
                'route' => 'reports.customers',
            ],
            [
                'label' => 'Reseller',
                'route' => 'reports.reseller',
            ],
            [
                'label' => 'Upstream',
                'route' => 'reports.upstream',
            ],
            [
                'label' => 'Cash Book',
                'route' => 'report.cashbook',
            ],
            [
                'label' => 'Ledger',
                'route' => 'report.ledger',
            ],
            [
                'label' => 'Trial Balance',
                'route' => 'report.trialbalance',
            ],
            [
                'label' => 'Income Statement',
                'route' => 'report.incomestatement',
            ],
            [
                'label' => 'Balance Sheet',
                'route' => 'report.balancesheet',
            ],
        ]
    ],

    [
        'label' => 'SMS Service',
        'route' => null,
        'access' => 'smsservice',
        'icon' => 'fas fa-sms',
        'parent_id' => 0,
        'submenu' => [
            [
                'label' => 'All Sms',
                'route' => 'sms.index',
            ],
            [
                'label' => 'Create Sms',
                'route' => 'sms.create',
            ],
        ]
    ],

    [
        'label' => 'Business Setup',
        'route' => null,
        'access' => 'businesses',
        'icon' => 'fa fa-briefcase',
        'parent_id' => 0,
        'submenu' => [
            [
                'label' => 'Manage Businesses',
                'route' => 'businesses.index',
            ],
            [
                'label' => 'Add New Business',
                'route' => 'businesses.create',
            ],

        ]
    ],

    [
        'label' => 'System',
        'route' => null,
        'access' => 'system',
        'icon' => 'fa fa-cogs',
        'parent_id' => 0,
        'submenu' => [
            [
                'label' => 'User Roll',
                'route' => 'rollPermission.index',
            ],
            [
                'label' => 'Company Setup',
                'route' => 'companies.index',
            ],

        ]
    ],
];

return $menus;
