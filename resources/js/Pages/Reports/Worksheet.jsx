import React, { useEffect, useRef, useState } from 'react'
import Layout from '../../Shared/Layout'
import InputSelectWithSearch from '../../Shared/InputSelectWithSearch'
import InputDate from '../../Shared/InputDate'
import { toYearMonthDay } from '../../Shared/utils'
import { router } from '@inertiajs/react'

const Worksheet = ({ accounts }) => {

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
                                    </tr>
                                ))}
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </Layout>
    )
}

export default Worksheet
