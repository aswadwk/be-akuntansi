import React, { useEffect, useRef, useState } from 'react'
import Layout from '../../Shared/Layout'
import InputSelectWithSearch from '../../Shared/InputSelectWithSearch'
import InputDate from '../../Shared/InputDate'
import { toIDR, toYearMonthDay } from '../../Shared/utils'
import { router } from '@inertiajs/react'

const Worksheet = ({ accounts }) => {
    console.log(accounts)

    const [filters, setFilters] = useState({
        end_date: new Date(),
    });

    const handleFilter = ({
        dateFilter,
    }) => {

        if (dateFilter) {
            const newDate = toYearMonthDay(dateFilter);
            router.get(
                `/reports/worksheet`, { end_date: newDate },
                { preserveState: true }
            );
        }
    }

    const firstRender = useRef(true);

    useEffect(() => {
        if (firstRender.current) {
            firstRender.current = false;
            return;
        }

        handleFilter({
            dateFilter: filters.end_date,
        });
    }, [filters]);

    return (
        <Layout left={'Neraca Lajur'} right={<></>}>
            <div className="card">
                <div className="card-body border-bottom">
                    <div className="row">
                        <div className="col-md-3 form-group">
                            <div className="input-icon mb-2">
                                <InputDate
                                    format={'yyyy-MM-dd'}
                                    label="Tanggal"
                                    value={filters.end_date}
                                    onChange={(value) => setFilters({ ...filters, end_date: value })}
                                    isRequired
                                />
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div className="card mt-3">
                <div className="card-body border-bottom p-0">
                    <div className="table-responsive">
                        <table className="table table-vcenter card-table">
                            <thead>
                                <tr>
                                    <th rowSpan={2} className="text-center">Kode</th>
                                    <th rowSpan={2} className="text-center">Nama Akun</th>
                                    <th colSpan={2} className="text-center">Neraca Saldo</th>
                                    <th colSpan={2} className="text-center">Laba Rugi</th>
                                    <th colSpan={2} className="text-center">Neraca</th>
                                </tr>
                                <tr>
                                    <td className="text-center">Debet</td>
                                    <td className="text-center">Kredit</td>
                                    <td className="text-center">Debet</td>
                                    <td className="text-center">Kredit</td>
                                    <td className="text-center">Debet</td>
                                    <td className="text-center">Kredit</td>
                                </tr>
                            </thead>
                            <tbody>
                                {accounts.length === 0 && (
                                    <tr>
                                        <td colSpan={8} className="text-center">
                                            Data tidak ditemukan
                                        </td>
                                    </tr>
                                )}
                                {accounts.map((item) => (
                                    <tr key={item.id}>
                                        <td>{item.code}</td>
                                        <td>{item.name}</td>
                                        <td className='text-end'>{toIDR(item.balance_sheet_debit)}</td>
                                        <td className='text-end'>{toIDR(item.balance_sheet_credit)}</td>
                                        <td className='text-end'>{toIDR(item.profit_loss_debit)}</td>
                                        <td className='text-end'>{toIDR(item.profit_loss_credit)}</td>
                                        <td className='text-end'>{toIDR(item.debit)}</td>
                                        <td className='text-end'>{toIDR(item.credit)}</td>
                                    </tr>
                                ))}
                            </tbody>
                            <tfoot>
                                <tr style={{ background: 'bisque' }}>
                                    <td colSpan={2} className="text-end">
                                        Total
                                    </td>
                                    <td className="text-end">
                                        {toIDR(accounts.reduce((acc, item) => acc + Number(item.balance_sheet_debit), 0))}
                                    </td>
                                    <td className="text-end">
                                        {toIDR(accounts.reduce((acc, item) => acc + Number(item.balance_sheet_credit), 0))}
                                    </td>
                                    <td className="text-end">
                                        {toIDR(accounts.reduce((acc, item) => acc + Number(item.profit_loss_debit), 0))}
                                    </td>
                                    <td className="text-end">
                                        {toIDR(accounts.reduce((acc, item) => acc + Number(item.profit_loss_credit), 0))}
                                    </td>
                                    <td className="text-end">
                                        {toIDR(accounts.reduce((acc, item) => acc + Number(item.debit), 0))}
                                    </td>
                                    <td className="text-end">
                                        {toIDR(accounts.reduce((acc, item) => acc + Number(item.credit), 0))}
                                    </td>
                                </tr>
                                <tr>
                                    <td colSpan={3} className="text-end"></td>
                                    <td className="text-end">Laba / Rugi</td>

                                    <td className="text-end" style={{ background: 'bisque' }}>
                                        -
                                    </td>
                                    <td className="text-end" style={{ background: 'bisque' }}>
                                        0
                                    </td>
                                    <td className="text-end" style={{ background: 'bisque' }}>
                                        -
                                    </td>
                                    <td className="text-end" style={{ background: 'bisque' }}>
                                        0
                                    </td>
                                </tr>
                                <tr>
                                    <td colSpan={5} className="text-center"></td>
                                    <td className="text-center">Balance</td>

                                    <td className="text-end" style={{ background: 'bisque' }}>
                                        0
                                    </td>
                                    <td className="text-end" style={{ background: 'bisque' }}>
                                        0
                                    </td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>

        </Layout>
    )
}

export default Worksheet
