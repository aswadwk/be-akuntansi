import React, { useState } from 'react'
import Layout from '../../Shared/Layout'
import { toIDR } from '../../Shared/utils'
import InputDate from '../../Shared/InputDate';



const BalanceSheet = ({ accounts, balanceSheets }) => {

    const [filters, setFilters] = useState({
        date: new Date(),
    });

    function calculateTotal(balanceSheetsParams, type) {
        const profit = balanceSheetsParams.filter((item) => item.type === 'profit');
        const loss = balanceSheetsParams.filter((item) => item.type === 'loss');

        // console.log(profit, loss.journals)
        console.log(profit[0].journals, loss[0].journals)

        const totalProfit = profit[0].journals.reduce((acc, item) => acc + Number(item.total), 0);
        const totalLoss = loss[0].journals.reduce((acc, item) => acc + Number(item.total), 0);

        if (type === 'profit') return totalProfit;

        if (type === 'loss') return totalLoss;

        return totalProfit - totalLoss;
    }


    return (
        <Layout left={'Laba Rugi'} right={<></>}>
            <div className="card mb-4">
                <div className="card-body border-bottom">
                    <div className="row">
                        <div className="col-md-3 form-group">
                            <div className="input-icon mb-2">
                                <InputDate
                                    format={'yyyy-MM-dd'}
                                    label="Tanggal"
                                    value={filters.date}
                                    onChange={(value) => setFilters({ ...filters, date: value })}
                                    isRequired
                                />
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div className="card overflow-hidden mb-4">
                <div className="table-responsive">
                    <table className='table table-vcenter card-table'>
                        <thead>
                            <tr>
                                <th>Akun</th>
                                <th>Keterangan</th>
                                <th className='text-center'>Total</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            {balanceSheets.map((item, index) => (
                                <>
                                    <tr>
                                        <td colspan="4">{item.title}</td>
                                    </tr>
                                    <tr>
                                        <td colspan="4">{item.sub_title ?? '-'}</td>
                                    </tr>
                                    {
                                        item.journals.map((journal) => (
                                            <tr key={journal.title}>
                                                <td>{journal.code}</td>
                                                <td>{journal.name}</td>
                                                <td className='text-end me-4'>{toIDR(journal.total)}</td>
                                                <td></td>
                                            </tr>
                                        ))
                                    }
                                    <tr>
                                        <td colspan="2" style={{ background: 'bisque' }}>Total {item.title}</td>
                                        <td className='text-end' style={{ background: 'bisque' }}>
                                            {toIDR(item.journals.reduce((acc, item) => acc + Number(item.total), 0))}
                                        </td>
                                        <td style={{ background: 'bisque' }}></td>
                                    </tr>
                                    <tr>
                                        <td colspan="4"></td>
                                    </tr>
                                </>
                            ))}
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="2" style={{ background: 'bisque' }}>JUMLAH AKTIVA</td>
                                <td className='text-end' style={{ background: 'bisque' }}>{toIDR(calculateTotal(balanceSheets, "profit"))}</td>
                                <td style={{ background: 'bisque' }}></td>
                            </tr>
                            <tr>
                                <td colspan="2" style={{ background: 'bisque' }}>JUMLAH PASSIVA</td>
                                <td className='text-end' style={{ background: 'bisque' }}>{toIDR(calculateTotal(balanceSheets, "loss"))}</td>
                                <td style={{ background: 'bisque' }}></td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
            {/* <pre>
                {JSON.stringify(balanceSheets, null, 2)}
            </pre>
            <pre>
                {JSON.stringify(accounts, null, 2)}
            </pre> */}

        </Layout>
    )
}

export default BalanceSheet
