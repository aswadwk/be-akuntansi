import Layout from '../../../Shared/Layout'
import axios from 'axios'
import FormSettingReport from './Form'

const BalanceSheet = ({ accounts, settings }) => {
    const onSubmit = (data) => {

        axios.post("/setting-reports/balance-sheet", {
            settings: data
        }).then((response) => {
            console.log(response)
        }).catch((error) => {
            console.log(error)
        }, {
            headers: {
                'Content-Type': 'application/json',
            }
        })
    }

    return (
        <Layout left={'Setting / Neraca'} right={<></>}>
            <FormSettingReport
                accounts={accounts}
                settings={settings}
                onSubmit={onSubmit}
            />
        </Layout>
    )
}

export default BalanceSheet
