import React from 'react'
import Layout from '../../Shared/Layout'
import { useForm } from '@inertiajs/react'
import Input from '../../Shared/Input'
import InputSelect from '../../Shared/InputSelect'
import InputNumber from '../../Shared/InputNumber'

const Create = ({ accountTypes }) => {

    const { data, setData, post, errors, transform } = useForm({
        name: "",
        code: "",
        position_normal: "",
        account_type_id: "",
        description: "",
        opening_balance: 0,
    })

    const onSubmit = (e) => {
        e.preventDefault()

        transform((data) => ({
            ...data,
            opening_balance: Number(data.opening_balance.toString().replaceAll(',', '').replace('IDR ', ''))
        }))

        post("/accounts")
    }

    return (
        <Layout left={"Account / Create"} right={<></>}>
            <div className="col-12 col-sm-6">
                <FormAddAccountType accountTypes={accountTypes} data={data} setData={setData} errors={errors} onSubmit={onSubmit} />
            </div>
        </Layout>
    )
}

export default Create


const FormAddAccountType = ({ onSubmit, data, errors, setData, accountTypes }) => {
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
                            label="Nama Akun"
                            placeholder="Nama"
                            onChange={e => setData("name", e.target.value)}
                            error={errors.name}
                            value={data.name}
                        />
                    </div>
                    <div className="mb-3">
                        <Input
                            label="Kode Akun"
                            placeholder="Kode"
                            onChange={e => setData("code", e.target.value)}
                            error={errors.code}
                            value={data.code}
                        />
                    </div>
                    <div className="mb-3">
                        <InputSelect placeholder={"Position Normal"} options={[
                            { label: "Debit", value: "D" },
                            { label: "Credit", value: "C" },
                        ]}
                            onChange={e => setData("position_normal", e.target.value)}
                            value={data.position_normal}
                            error={errors.position_normal}
                            label={"Posisi Normal"}
                        />
                    </div>
                    <div className="mb-3">
                        <InputSelect placeholder={"Account type"} options={accountTypes.map((item) => (
                            { label: item.name, value: item.id }
                        ))}
                            onChange={e => setData("account_type_id", e.target.value)}
                            value={data.account_type_id}
                            error={errors.account_type_id}
                            label={"Account type"}
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
                            prefix="IDR "
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
