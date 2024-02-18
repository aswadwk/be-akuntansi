import React, { useEffect, useRef, useState } from 'react'
import Layout from '../../Shared/Layout'
import { Link, useForm } from '@inertiajs/react'
import { dateHumanize, toYearMonthDayHourMinute } from '../../Shared/utils'
import Paginate, { PaginateInfo } from '../../Shared/Paginate'
import { IconEdit, IconTrash, IconPlus } from '@tabler/icons-react'
import { NumericFormat } from 'react-number-format'
import { debounce } from "lodash";
import { router } from '@inertiajs/react'

const Index = ({ accountHelpers }) => {
    const [filters, setFilters] = useState({
        name: '',
        per_page: 10,
        order_by: 'created_at',
        order: 'desc'
    });
    const { delete: destroy } = useForm({});

    const onDelete = (accountTypeId) => {
        if (confirm('Are you sure you want to delete this account type?')) {
            // Delete it!
            destroy(`/account-helpers/${accountTypeId}`)
        }
    }

    const debouncedSearch = useRef(
        debounce((searchFilter) => {
            router.get('/account-helpers', {
                ...searchFilter,
            }, { preserveState: true })
        }, 500)
    ).current;

    const firstRender = useRef(true);

    useEffect(() => {
        if (firstRender.current) {
            firstRender.current = false;
            return;
        }

        debouncedSearch(filters);
    }, [filters]);

    const onSort = (orderBy) => {
        const order = filters.order === 'desc' ? 'asc' : 'desc';
        setFilters({ ...filters, order_by: orderBy, order });
    }

    return (
        <Layout left={'Account Helpers(Kode Bantu)'} right={<PageTitleRight />}>
            <div className="col-12">
                <div className="card">
                    <div className="card-body border-bottom py-3">
                        <div className="d-flex">
                            <div className="text-secondary">
                                Show
                                <div className="mx-2 d-inline-block">
                                    <input
                                        type="text"
                                        className="form-control form-control-sm"
                                        value={filters.per_page}
                                        size="3"
                                        onChange={(e) => setFilters({ ...filters, per_page: e.target.value })}
                                    />
                                </div>
                                entries
                            </div>
                            <div className="ms-auto text-secondary">
                                Search:
                                <div className="ms-2 d-inline-block">
                                    <input
                                        type="text"
                                        className="form-control form-control-sm"
                                        value={filters.name}
                                        onChange={(e) => setFilters({ ...filters, name: e.target.value })}
                                    />
                                </div>
                            </div>
                        </div>
                    </div>
                    <div className="table-responsive">
                        <table className="table card-table table-vcenter text-nowrap datatable">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>
                                        <button
                                            className="table-sort"
                                            onClick={() => onSort('code')}
                                        >
                                            Code
                                        </button>
                                    </th>
                                    <th>Account Type</th>
                                    <th>Type</th>
                                    <th>Opening Balance</th>
                                    <th>Description</th>
                                    <th>
                                        <button
                                            className="table-sort"
                                            onClick={() => onSort('created_at')}
                                        >
                                            Created At
                                        </button>
                                    </th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                {
                                    accountHelpers.data.map((accountType, index) => (
                                        <tr key={index}>
                                            <td>{accountType.name}</td>
                                            <td>{accountType.code}</td>
                                            <td>
                                                <span className='text-capitalize'>
                                                    {accountType.account_type}
                                                </span>
                                            </td>
                                            <td>{accountType.position_normal === "D" ? 'Debit' : 'Credit'}</td>
                                            <td>
                                                <NumericFormat
                                                    displayType="text"
                                                    thousandSeparator="."
                                                    decimalScale={2}
                                                    prefix="Rp. "
                                                    decimalSeparator=","
                                                    value={accountType.opening_balance}
                                                />
                                            </td>
                                            <td>{accountType.description}</td>
                                            <td>{toYearMonthDayHourMinute(accountType.created_at)}
                                                <br />
                                                <span className="text-secondary">{dateHumanize(accountType.created_at)}</span>
                                            </td>
                                            <td>
                                                <Link href={`/account-helpers/${accountType.id}/edit`}>
                                                    <span className="cursor-pointer text-warning">
                                                        <IconEdit size={18} />
                                                    </span>
                                                </Link>
                                                <button
                                                    className="text-secondary cursor-pointer bg-transparent"
                                                    onClick={() => onDelete(accountType.id)} >
                                                    <IconTrash size={18} />
                                                </button>
                                            </td>
                                        </tr>
                                    ))
                                }
                            </tbody>
                        </table>
                    </div>
                    <div className="card-footer d-flex align-items-center">
                        <PaginateInfo from={accountHelpers.from} to={accountHelpers.to} total={accountHelpers.total} />
                        <Paginate links={accountHelpers.links} />
                    </div>
                </div>
            </div>
        </Layout>
    )
}

export default Index


const PageTitleRight = () => {
    return (
        <div className="col-auto ms-auto d-print-none">
            <div className="btn-list">
                <Link
                    href="/account-helpers/create"
                    className="btn btn-primary d-none d-sm-inline-block"
                >
                    <IconPlus />
                    Add Account Type
                </Link>
                <Link
                    href="/account-helpers/create"
                    className="btn btn-primary d-sm-none btn-icon"
                >
                    <IconPlus />
                </Link>
            </div>
        </div>
    )
}
