import React from 'react'
import Layout from '../../Shared/Layout'
import { useForm } from '@inertiajs/react'
import Input from '../../Shared/Input'
import InputSelect from '../../Shared/InputSelect'
import InputNumber from '../../Shared/InputNumber'

const Create = () => {

    const { data, setData, post, errors, transform } = useForm({
        name: "",
        code: "",
        account_type: "",
        type: "D",
        description: "",
        opening_balance: 0,
    })

    const onSubmit = (e) => {
        e.preventDefault()

        transform((data) => ({
            ...data,
            opening_balance: Number(data.opening_balance.toString().replaceAll(',', '').replace('Rp. ', '')),
        }));

        post("/account-helpers")
    }

    return (
        <Layout left={"Account Helpers / Create"} right={<></>}>
            <div className="col-12 col-sm-6">
                <FormAddAccountType data={data} setData={setData} errors={errors} onSubmit={onSubmit} />
            </div>
        </Layout>
    )
}

export default Create


const FormAddAccountType = ({ onSubmit, data, errors, setData }) => {
    const submit = (e) => {
        e.preventDefault()
        onSubmit(data)
    }

    return (
        <form onSubmit={submit}>
            <div className="card">
                <div className="card-body">
                    <div className="mb-3">
                        <Input
                            label="Name"
                            isRequired
                            placeholder="Nama"
                            onChange={e => setData("name", e.target.value)}
                            error={errors.name}
                            value={data.name}
                        />
                    </div>
                    <div className="mb-3">
                        <Input
                            isRequired
                            label="Code"
                            placeholder="Code"
                            onChange={e => setData("code", e.target.value)}
                            error={errors.code}
                            value={data.code}
                        />
                    </div>
                    <div className="mb-3">
                        <InputSelect
                            isRequired
                            placeholder={"Account Type"}
                            options={[
                                { label: "Debit (Hutang)", value: "debit" },
                                { label: "Credit (Piutang)", value: "credit" },
                                { label: "Project", value: "project" },
                            ]}
                            onChange={e => setData("account_type", e.target.value)}
                            value={data.account_type}
                            error={errors.account_type}
                            label={"Type"}
                        />
                    </div>
                    <div className="mb-3">
                        <InputSelect
                            isRequired
                            placeholder={"Type"}
                            options={[
                                { label: "Debit", value: "D" },
                                { label: "Credit", value: "C" },
                            ]}
                            onChange={e => setData("type", e.target.value)}
                            value={data.type}
                            error={errors.type}
                            label={"Type"}
                        />
                    </div>
                    <div className="mb-3">
                        <InputNumber
                            label="Opening Balance"
                            onChange={e => setData("opening_balance", e.target.value)}
                            error={errors.opening_balance}
                            value={data.opening_balance}
                            placeholder="Balance"
                            isRequired
                            prefix="Rp. "
                        />
                    </div>
                    <div className="mb-3">
                        <Input
                            label="Description"
                            placeholder="Description"
                            onChange={e => setData("description", e.target.value)}
                            error={errors.description}
                            value={data.description}
                        />
                    </div>
                </div>
                <div className="card-footer text-end">
                    <button className='btn btn-primary' onClick={onSubmit}>Save</button>
                </div>
            </div>
        </form>
    )
}
