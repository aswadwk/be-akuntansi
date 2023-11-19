import React, { useState } from 'react'
import Select from 'react-select';
import { NumericFormat } from 'react-number-format';
import { useForm } from '@inertiajs/react';

const initialJournal = {
    date: '',
    description: '',
    journals: [
        {
            amount: '',
            type: '',
            account_id: '',
        },
        {
            amount: '',
            type: '',
            account_id: '',
        },
    ],
};

const Create = ({ accounts }) => {
    const [isLoading, setIsLoading] = React.useState(false);
    const [newJournal, setNewJournal] = useState(initialJournal);

    const { data, setData, post } = useForm({})

    function sumArray(array) {
        let sum = 0;
        for (const value of array) {
            sum += value;
        }
        return sum;
    }

    function filterType(journals, type) {
        return sumArray(
            journals
                .filter((row) => row.type === type)
                .map((row) => parseInt(row.amount.toString().replace('Rp. ', '').replaceAll('.', ''))),
        );
    }

    function handleReset() {
        window.location.reload();
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
            alert('Minimal 2 baris');
            // return enqueueSnackbar('Minimal 2 baris', { variant: 'error' });
        }

        const newRow = [...newJournal.journals];
        newRow.splice(index, 1);

        setNewJournal({ ...newJournal, journals: newRow });
    };

    function handleChangeAmount(event, index, type) {
        setNewJournal((prevJournal) => {
            const updatedJournals = prevJournal.journals.map((row, i) => {
                if (i === index) {
                    return {
                        ...row,
                        amount: event.target.value,
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

    async function handleSubmit(event) {
        event.preventDefault();

        setIsLoading(true);
        const newJournalPost = ({
            ...newJournal,
            journals: newJournal.journals.map((row) => ({
                ...row,
                amount: row.amount.toString().replace('Rp. ', '').replaceAll('.', ''),
            })),
        });

        setData({ ...newJournalPost });

        post('/journals')
    }

    return (
        <div className="col-12">
            <div className="card">
                <form onSubmit={handleSubmit}>
                    <div className="card-header">
                        <h3 className="card-title">Form Tambah Jurnal</h3>
                    </div>
                    <div className="card-body">
                        <div className="row row-cards">
                            <div className="mb-3 col-sm-4 col-md-2">
                                <label className="form-label required">Tanggal</label>
                                <input
                                    value={newJournal.date}
                                    onChange={(event) => setNewJournal({ ...newJournal, date: event.target.value })}
                                    className="form-control"
                                    required
                                    type="date"
                                />
                            </div>
                        </div>

                        <div className="mb-3">
                            <label className="form-label">Keterangan</label>
                            <textarea
                                placeholder="Masukkan keterangan"
                                className="form-control"
                                rows={2}
                                onChange={(event) => setNewJournal({ ...newJournal, description: event.target.value })}
                                value={newJournal.description}
                            >
                                {newJournal.description}
                            </textarea>
                        </div>
                        <div className="table-responsive" style={{ overflowX: 'unset' }}>
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
                                                <Select
                                                    className="basic-single"
                                                    classNamePrefix="select"
                                                    defaultValue={{
                                                        label: 'Pilih Akun',
                                                        value: '',
                                                    }}
                                                    options={accounts.map((item) => ({
                                                        label: item.name + ' - ' + item.code,
                                                        value: item.id,
                                                    }))}
                                                    onChange={(event) => {
                                                        setNewJournal({
                                                            ...newJournal,
                                                            journals: newJournal.journals.map((row, i) => {
                                                                if (i === index) {
                                                                    return {
                                                                        ...row,
                                                                        account_id: event.value,
                                                                    };
                                                                }
                                                                return row;
                                                            }),
                                                        });
                                                    }}
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
                            <button type="button" onClick={handleReset} className="btn btn-outline-secondary">
                                Reset
                            </button>
                            {filterType(newJournal.journals, 'D') === filterType(newJournal.journals, 'C') ? (
                                <button className="btn btn-primary gap-2" type="submit">
                                    {isLoading && (
                                        <span className="spinner-border spinner-border-sm" role="status" aria-hidden="true" />
                                    )}
                                    Simpan
                                </button>
                            ) : (
                                <button className="btn btn-primary" disabled>
                                    Simpan
                                </button>
                            )}
                        </div>
                    </div>
                </form>
            </div>
        </div>
    )
}

export default Create
