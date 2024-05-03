import React from 'react'
import Layout from '../../Shared/Layout'

const ProfitLoss = ({ accounts }) => {
    return (
        <Layout left={'Laba Rugi'} right={<></>}>
            <pre>
                {JSON.stringify(accounts, null, 2)}
            </pre>
            <div className="card">
                <div className="table-responsive">
                    <table className="table table-vcenter card-table">
                        <thead>
                            <tr>
                                <th>Tanggal</th>
                                <th>Keterangan</th>
                                <th>Debet</th>
                                <th>Kredit</th>
                                <th>Saldo</th>
                                {/* <th className="text-center">Aksi</th> */}
                            </tr>
                        </thead>
                        <tbody>
                            {/* {journals.length === 0 && (
                                <tr>
                                    <td colSpan={8} className="text-center">
                                        Data tidak ditemukan
                                    </td>
                                </tr>
                            )}
                            {journals.map((item) => (
                                <tr key={item.id}>
                                    <td>{toDayMonthYear(item.date)}</td>
                                    <td>{item.description}</td>
                                    <td>{toIDR(item.debit)}</td>
                                    <td>{toIDR(item.credit)}</td>
                                    <td>
                                        {toIDR(item.balance)}
                                    </td>
                                </tr>
                            ))} */}
                        </tbody>
                    </table>
                </div>
            </div>
        </Layout>
    )
}

export default ProfitLoss
