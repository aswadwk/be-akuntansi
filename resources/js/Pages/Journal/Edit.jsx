
import { useForm } from '@inertiajs/react';
import React, { useState } from 'react'
import { NumericFormat } from 'react-number-format';
import InputSelectWithSearch from '../../Shared/InputSelectWithSearch';

const Edit = ({ accounts, journals, accountHelpers }) => {
    const { data, setData, processing, put } = useForm({
        id: journals.id,
    })

    const [isLoading, setIsLoading] = useState(false);

    const [newJournal, setNewJournal] = useState({
        id: journals.id,
        date: new Date(journals.journals[0].date).toISOString().split('T')[0],
        description: journals.journals[0].description,
        account_helper_id: journals.journals[0].account_helper_id || '',
        journals: journals.journals.map((row) => ({
            amount: row.amount,
            type: row.type,
            account_id: row.account_id,
        })),
    });

    function sumArray(array) {
        let sum = 0;
        for (const value of array) {
            sum += value;
        }
        return sum;
    }

    function handleChangeAmount(event, index, type) {
        setNewJournal((prevJournal) => {
            const updatedJournals = prevJournal.journals.map((row, i) => {
                if (i === index) {
                    return {
                        ...row,
                        amount: event.target.value.toString().replace('Rp. ', '').replaceAll('.', ''),
                        type: type,
                    };
                }
                return row;
            });

            return {
                ...prevJournal,
                journals: updatedJournals,
            };
        });
    }

    function filterType(journals, type) {
        return sumArray(
            journals
                .filter((row) => row.type === type)
                .map((row) => parseInt(row.amount.toString().replace('Rp. ', '').replaceAll('.', ''))),
        );
    }

    const addRow = () => {
        const newRow = [...newJournal.journals];
        newRow.push({
            amount: '',
            type: '',
            account_id: '',
        });

        setNewJournal({ ...newJournal, journals: newRow });
    };

    const deleteRow = (index) => {
        if (newJournal.journals.length === 2) {
            return enqueueSnackbar('Minimal 2 baris', { variant: 'error' });
        }

        const newRow = [...newJournal.journals];
        newRow.splice(index, 1);

        setNewJournal({ ...newJournal, journals: newRow });
    };

    function handleSubmit(event) {
        event.preventDefault();

        setIsLoading(true);
        setData({
            ...newJournal,
            journals: newJournal.journals.map((row) => ({
                ...row,
                amount: row.amount.toString().replace('Rp. ', '').replaceAll('.', ''),
            })),
        });

        console.log('update ', data);
        put(`/journals/${data.id}`)
    }

    return (
        <div className="col-12">
            <div className="card">
                <form onSubmit={handleSubmit}>
                    <div className="card-header">
                        <h3 className="card-title">Form Update Journal</h3>
                    </div>
                    <div className="card-body">
                        <div className="row row-cards">
                            <div className="mb-3 col-sm-4 col-md-2">
                                <label className="form-label required">Date</label>
                                <input
                                    value={newJournal.date}
                                    onChange={(event) =>
                                        setNewJournal({
                                            ...newJournal,
                                            date: event.target.value,
                                        })
                                    }
                                    className="form-control"
                                    required
                                    type="date"
                                />
                            </div>
                            <div className="mb-3 col-sm-6 col-md-4">
                                <InputSelectWithSearch
                                    label="Kode Bantu"
                                    defaultValue={{
                                        label: 'Pilih Akun',
                                        value: '',
                                    }}
                                    options={accountHelpers.map((item) => ({
                                        label: item.name + ' - ' + item.code,
                                        value: item.id,
                                    }))}
                                    value={newJournal.account_helper_id}
                                    onChange={(value) => {
                                        setNewJournal({
                                            ...newJournal,
                                            account_helper_id: value,
                                        });
                                    }}
                                />
                            </div>
                        </div>
                        <div className="mb-3">
                            <label className="form-label">Description</label>
                            <textarea
                                placeholder="Masukkan keterangan"
                                className="form-control"
                                rows={2}
                                onChange={(event) =>
                                    setNewJournal({
                                        ...newJournal,
                                        description: event.target.value,
                                    })
                                }
                                value={newJournal.description}
                            >
                                {newJournal.description}
                            </textarea>
                        </div>
                        <div className="table-responsive">
                            <table className="table mb-0">
                                <thead>
                                    <tr>
                                        <th>Akun</th>
                                        <th>Debet</th>
                                        <th>Kredit</th>
                                        <th className="w-1">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    {newJournal.journals.map((journal, index) => (
                                        <tr key={index}>
                                            <td>
                                                <InputSelectWithSearch
                                                    onChange={(value) => {
                                                        setNewJournal({
                                                            ...newJournal,
                                                            journals: newJournal.journals.map((row, i) => {
                                                                if (i === index) {
                                                                    return {
                                                                        ...row,
                                                                        account_id: value,
                                                                    };
                                                                }
                                                                return row;
                                                            }),
                                                        });
                                                    }
                                                    }
                                                    value={journal.account_id}
                                                    options={accounts.map((account) => ({
                                                        label: account.name,
                                                        value: account.id,
                                                    }))}
                                                />
                                            </td>
                                            <td>
                                                <NumericFormat
                                                    className="form-control text-end"
                                                    thousandSeparator="."
                                                    decimalScale={0}
                                                    prefix="Rp. "
                                                    decimalSeparator=","
                                                    value={journal.type === 'D' ? journal.amount : 0}
                                                    onChange={(event) => handleChangeAmount(event, index, 'D')}
                                                />
                                            </td>
                                            <td>
                                                <NumericFormat
                                                    className="form-control text-end"
                                                    allowLeadingZeros
                                                    decimalScale={0}
                                                    thousandSeparator="."
                                                    prefix="Rp. "
                                                    decimalSeparator=","
                                                    value={journal.type === 'C' ? journal.amount : 0}
                                                    onChange={(event) => handleChangeAmount(event, index, 'C')}
                                                />
                                            </td>
                                            <td>
                                                <button className="btn btn-outline-danger" onClick={() => deleteRow(index)}>
                                                    -
                                                </button>
                                            </td>
                                        </tr>
                                    ))}
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td>
                                            <button className="btn btn-outline-primary" onClick={addRow}>
                                                Tambah
                                            </button>
                                        </td>
                                        <td className="text-end me-12">
                                            <NumericFormat
                                                displayType="text"
                                                thousandSeparator="."
                                                decimalScale={0}
                                                prefix="Rp. "
                                                decimalSeparator=","
                                                value={filterType(newJournal.journals, 'D')}
                                            />
                                        </td>
                                        <td className="text-end me-2">
                                            <NumericFormat
                                                displayType="text"
                                                thousandSeparator="."
                                                decimalScale={0}
                                                prefix="Rp. "
                                                decimalSeparator=","
                                                value={filterType(newJournal.journals, 'C')}
                                            />
                                        </td>
                                        <td></td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                    <div className="card-footer text-end">
                        <div className="d-flex gap-2 justify-content-end">
                            <button type="button" onClick={() => window.location.reload()} className="btn btn-outline-secondary">
                                Reset
                            </button>
                            {filterType(newJournal.journals, 'D') === filterType(newJournal.journals, 'C') ? (
                                <button className="btn btn-primary gap-2" type="submit">
                                    {isLoading && (
                                        <span className="spinner-border spinner-border-sm" role="status" aria-hidden="true" />
                                    )}
                                    Update
                                </button>
                            ) : (
                                <input type='submit' className="btn btn-primary" disabled>
                                    Update
                                </input>
                            )}
                        </div>
                    </div>
                </form>
            </div>
        </div>
    )
}

export default Edit
