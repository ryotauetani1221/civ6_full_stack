import type { NextPage } from 'next'
import Head from 'next/head'
import Image from 'next/image'
import styles from '../styles/Home.module.css'


const Home: NextPage = () => {
    return (
        <div className={styles.container}>
            <Head>
                <title>Create Next App test!!!!</title>
                <meta name="description" content="Generated by create next app" />
                <link rel="icon" href="/favicon.ico" />
            </Head>

            <main className={styles.main}>
                <h1 className={styles.title}>
                    Welcome to <a href="https://nextjs.org">Next.js! test!!!</a>
                </h1>
                <ul>
                    {styles.main}
                </ul>
            </main>

            <footer className={styles.footer}>
                <a
                    href="https://vercel.com?utm_source=create-next-app&utm_medium=default-template&utm_campaign=create-next-app"
                    target="_blank"
                    rel="noopener noreferrer"
                >
                    Powered by{' '}
                    <span className={styles.logo}>
                        <Image src="/vercel.svg" alt="Vercel Logo" width={72} height={16} />
                    </span>
                </a>
            </footer>
        </div>
    )
}
// export default Home

export async function getServerSideProps() {
    const res = await fetch(`http://nginx:80/api/areas`)
    const data = await res.json()

    if (!data) {
        return {
            notFound: true,
        }
    }
    console.log(data[0]['id']);
    return {
        props: { data }, // will be passed to the page component as props
    }
}


export default function index({ data }) {
    return (
        <div>
            <h1>POST一覧</h1>
            <ul>
                {data.map((post) => {
                    return <li key={post.id}>{post.id}：{post.effect}</li>;
                })}
            </ul>
        </div>
    );
}
